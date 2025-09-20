<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:reports_view')->only(['salesReport']);
    }
    
    public function salesReport(Request $request)
    {
        // Get filter parameters
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Build query
        $query = Order::where('status', 'delivered')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc');

        // Get results
        $orders = $query->paginate(10);

        // Calculate totals
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Export logic
        if ($request->has('export')) {
            $exportType = $request->input('export');

            if ($exportType === 'pdf') {
                $pdf = Pdf::loadView('admin.reports.pdf', [
                    'orders' => $orders,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'totalSales' => $totalSales,
                    'totalOrders' => $totalOrders,
                    'avgOrderValue' => $avgOrderValue
                ]);

                return $pdf->download('sales-report-' . $startDate . '-to-' . $endDate . '.pdf');
            }
        }

        return view('admin.reports.index', compact(
            'orders',
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'avgOrderValue'
        ));
    }
}