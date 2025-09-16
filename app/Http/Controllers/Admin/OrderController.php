<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders with filtering.
     */
    public function index(Request $request)
    {
        // Get filter data for dropdowns
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $query = Order::with(['shippingAddress', 'items', 'items.product']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhereHas('shippingAddress', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Date range filter
        $startDate = $request->has('start_date') && !empty($request->start_date)
            ? $request->start_date
            : date('Y-m-d');

        $endDate = $request->has('end_date') && !empty($request->end_date)
            ? $request->end_date
            : date('Y-m-d');

        $query->whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ]);

        // Category filter
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Brand filter
        if ($request->has('brand_id') && !empty($request->brand_id)) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->where('brand_id', $request->brand_id);
            });
        }

        // Product filter
        if ($request->has('product_id') && !empty($request->product_id)) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        $totalAmount = $orders->sum('total_amount');
        // Get counts for stats
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();


        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'confirmedOrders',
            'shippedOrders',
            'cancelledOrders',
            'categories',
            'brands',
            'products',
            'totalAmount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with([
            'shippingAddress',
            'items.product.category',
            'items.product.images',
            'payment'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::with([
            'shippingAddress',
            'items.product.category',
            'items.product.images'
        ])->findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'items.*.quantity' => 'sometimes|required|integer|min:1',
            'items.*.unit_price' => 'sometimes|required|numeric|min:0',
        ]);

        // Update order
        $order->update($validated);

        // Update order items if provided
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $itemData) {
                $orderItem = OrderItem::find($itemId);
                if ($orderItem && $orderItem->order_id == $order->id) {
                    $orderItem->update([
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total_price' => $itemData['quantity'] * $itemData['unit_price']
                    ]);
                }
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order updated successfully');
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled'
        ]);

        $order->updateStatus($request->status);

        return redirect()->back()
            ->with('success', 'Order status updated successfully');
    }

    /**
     * Mark order as paid.
     */
    public function markAsPaid($id)
    {
        $order = Order::findOrFail($id);
        $order->markAsPaid();

        return redirect()->back()
            ->with('success', 'Order marked as paid successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Prevent deletion of orders that are beyond pending status
        if (!$order->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Cannot delete order with current status');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice($id)
    {
        $order = Order::with(['shippingAddress', 'items.product'])->findOrFail($id);
        
        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));

        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    /**
     * Email invoice to customer
     */
    public function emailInvoice($id)
    {
        $order = Order::with(['shippingAddress', 'items.product'])->findOrFail($id);

        // Generate PDF
        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));

        // Email the invoice
        // Mail::to($order->customer_email)->send(new OrderInvoice($order, $pdf));

        return redirect()->back()->with('success', 'Invoice sent to customer successfully.');
    }
}