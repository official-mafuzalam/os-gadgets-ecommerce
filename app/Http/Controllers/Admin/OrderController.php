<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $orders = Order::with('shippingAddress', 'items')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display today's orders.
     */
    public function todayOrders()
    {
        $orders = Order::with('shippingAddress', 'items')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display orders by date range.
     */
    public function ordersByDate(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date') ?? $startDate;

        $orders = Order::with('shippingAddress', 'items')
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders', 'startDate', 'endDate'));
    }

    /**
     * Display orders by status.
     */
    public function ordersByStatus($status)
    {
        $validStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            abort(404, 'Invalid order status');
        }

        $orders = Order::with('shippingAddress', 'items')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders', 'status'));
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
        $order = Order::with('shippingAddress', 'items.product', 'payment')
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::with('shippingAddress', 'items.product')
            ->findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $order->update($validated);

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
}