<x-admin-layout>
    @section('title', 'Sales Report')
    <x-slot name="main">
        <!-- Header with Breadcrumb -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Sales Report</h1>
                    <div class="flex items-center space-x-2">
                        <a href="{{ url()->previous() }}"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                <i class="fas fa-file-export mr-2"></i> Export
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                <div class="py-1">
                                    <button type="button" onclick="printReport()"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-print mr-2"></i> Print Report
                                    </button>
                                    <a href="{{ route('admin.reports.sales', array_merge(request()->all(), ['export' => 'pdf'])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-download mr-2"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <!-- Filter Form -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Filter Report
                </h2>
                <form method="GET" action="{{ route('admin.reports.sales') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Start Date
                            </label>
                            <input type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="start_date" name="start_date" value="{{ $startDate }}" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                End Date
                            </label>
                            <input type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="end_date" name="end_date" value="{{ $endDate }}" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                                Apply Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Sales</p>
                            <p class="text-lg font-semibold text-gray-900">${{ number_format($totalSales, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                            <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                            <p class="text-lg font-semibold text-gray-900">${{ number_format($avgOrderValue, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                            <i class="fas fa-calendar text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Date Range</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $startDate }} to {{ $endDate }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Sales Report ({{ $startDate }} to {{ $endDate }})
                        <span class="text-sm text-gray-600">({{ $orders->total() }} records found)</span>
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order #
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Items
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Shipping
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Discount
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $order->order_number }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->customer_email }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->items->count() }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($order->subtotal, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($order->shipping_cost, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($order->discount_amount, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($order->total_amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No orders found for the selected date range.
                                    </td>
                                </tr>
                            @endforelse

                            <!-- Totals Row -->
                            @if ($orders->isNotEmpty())
                                <tr class="bg-gray-50 font-semibold">
                                    <td colspan="3" class="px-6 py-4 text-sm text-gray-900 text-right">
                                        TOTALS:
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $orders->sum(fn($order) => $order->items->count()) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        ${{ number_format($orders->sum('subtotal'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        ${{ number_format($orders->sum('shipping_cost'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        ${{ number_format($orders->sum('discount_amount'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        ${{ number_format($orders->sum('total_amount'), 2) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div
                        class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $orders->firstItem() }}</span> to <span
                                class="font-medium">{{ $orders->lastItem() }}</span> of <span
                                class="font-medium">{{ $orders->total() }}</span> results
                        </div>

                        <div class="flex gap-2">
                            <!-- Previous Button -->
                            @if ($orders->onFirstPage())
                                <button disabled
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed">
                                    Previous
                                </button>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            <!-- Next Button -->
                            @if ($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                    Next
                                </a>
                            @else
                                <button disabled
                                    class="px-3 py-1 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed">
                                    Next
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Report Template (Hidden by default, shown when printing) -->
        <div id="report-template" class="hidden">
            <div class="bg-white p-8 max-w-6xl mx-auto">
                <!-- Report Header -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">SALES REPORT</h1>
                        <p class="text-gray-600">Period: {{ $startDate }} to {{ $endDate }}</p>
                        <p class="text-gray-600">Generated on: {{ now()->format('F j, Y h:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-semibold">{{ setting('site_name') }}</h2>
                        <p class="text-gray-600">{{ setting('site_email') }}</p>
                        <p class="text-gray-600">{{ setting('site_phone') }}</p>
                        <p class="text-gray-600">{{ setting('site_address') }}</p>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="grid grid-cols-4 gap-4 mb-8">
                    <div class="p-4 border border-gray-200 rounded-lg text-center">
                        <p class="text-2xl font-bold text-blue-700">${{ number_format($totalSales, 2) }}</p>
                        <p class="text-sm text-gray-600">Total Sales</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg text-center">
                        <p class="text-2xl font-bold text-green-700">{{ $totalOrders }}</p>
                        <p class="text-sm text-gray-600">Total Orders</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg text-center">
                        <p class="text-2xl font-bold text-purple-700">${{ number_format($avgOrderValue, 2) }}</p>
                        <p class="text-sm text-gray-600">Avg Order Value</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg text-center">
                        <p class="text-lg font-bold text-gray-700">{{ $orders->total() }}</p>
                        <p class="text-sm text-gray-600">Records</p>
                    </div>
                </div>

                <!-- Orders Table -->
                <table class="w-full mb-8">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="text-left py-2">Order #</th>
                            <th class="text-left py-2">Date</th>
                            <th class="text-left py-2">Customer</th>
                            <th class="text-right py-2">Items</th>
                            <th class="text-right py-2">Subtotal</th>
                            <th class="text-right py-2">Shipping</th>
                            <th class="text-right py-2">Discount</th>
                            <th class="text-right py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-200">
                                <td class="py-3">{{ $order->order_number }}</td>
                                <td class="py-3">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-3">{{ $order->customer_email }}</td>
                                <td class="text-right py-3">{{ $order->items->count() }}</td>
                                <td class="text-right py-3">${{ number_format($order->subtotal, 2) }}</td>
                                <td class="text-right py-3">${{ number_format($order->shipping_cost, 2) }}</td>
                                <td class="text-right py-3">${{ number_format($order->discount_amount, 2) }}</td>
                                <td class="text-right py-3">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-300 font-semibold">
                            <td colspan="3" class="py-3 text-right">TOTALS:</td>
                            <td class="text-right py-3">{{ $orders->sum(fn($order) => $order->items->count()) }}</td>
                            <td class="text-right py-3">${{ number_format($orders->sum('subtotal'), 2) }}</td>
                            <td class="text-right py-3">${{ number_format($orders->sum('shipping_cost'), 2) }}</td>
                            <td class="text-right py-3">${{ number_format($orders->sum('discount_amount'), 2) }}</td>
                            <td class="text-right py-3">${{ number_format($orders->sum('total_amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Summary Analysis -->
                <div class="mt-12 p-6 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium mb-2">Performance Metrics</h4>
                            <ul class="text-sm text-gray-700 space-y-1">
                                <li>Total Sales: <span
                                        class="font-semibold">${{ number_format($totalSales, 2) }}</span></li>
                                <li>Number of Orders: <span class="font-semibold">{{ $totalOrders }}</span></li>
                                <li>Average Order Value: <span
                                        class="font-semibold">${{ number_format($avgOrderValue, 2) }}</span></li>
                                <li>Date Range: <span class="font-semibold">{{ $startDate }} to
                                        {{ $endDate }}</span></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium mb-2">Additional Information</h4>
                            <ul class="text-sm text-gray-700 space-y-1">
                                <li>Report Generated: <span
                                        class="font-semibold">{{ now()->format('F j, Y h:i A') }}</span></li>
                                <li>Records Shown: <span class="font-semibold">{{ $orders->total() }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Report Printing -->
        <script>
            function printReport() {
                // Create a new window for printing
                const printWindow = window.open('', '_blank');

                // Get the report template HTML
                const reportContent = document.getElementById('report-template').innerHTML;

                // Write the print document
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Sales Report - {{ $startDate }} to {{ $endDate }}</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                        <script src="https://cdn.tailwindcss.com"><\/script>
                        <style>
                            @media print {
                                body { margin: 0; padding: 0; }
                                .no-print { display: none !important; }
                                @page { 
                                    margin: 15mm;
                                    size: landscape;
                                }
                                table { 
                                    width: 100%; 
                                    font-size: 10px;
                                }
                                .text-sm { font-size: 10px; }
                                .text-lg { font-size: 12px; }
                                .text-xl { font-size: 14px; }
                                .text-2xl { font-size: 16px; }
                                .text-3xl { font-size: 18px; }
                                .p-8 { padding: 15px; }
                                .max-w-6xl { max-width: 100%; }
                                .gap-4 { gap: 8px; }
                                .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
                            }
                            body { font-family: Arial, sans-serif; }
                        </style>
                    </head>
                    <body>
                        ${reportContent}
                        <script>
                            window.onload = function() {
                                window.print();
                                setTimeout(function() {
                                    window.close();
                                }, 500);
                            }
                        <\/script>
                    </body>
                    </html>
                `);

                printWindow.document.close();
            }
        </script>
    </x-slot>
</x-admin-layout>
