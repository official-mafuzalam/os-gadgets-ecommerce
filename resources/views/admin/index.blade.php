<x-admin-layout>
    @section('title', 'Dashboard')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
            </div>
            <div class="">
                <!-- Stats grid -->
                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
                    <!-- Total Products -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-box text-blue-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Total
                                            Products</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $productStats['total'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Products -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Active
                                            Products</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $productStats['active'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shopping-cart text-yellow-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Total
                                            Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['total'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Cancelled Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Total Cancelled Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['total_cancelled'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Revenue -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Today's Revenue</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ number_format($orderStats['today_revenue'] ?? 0, 2) }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Total Revenue</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['total_revenue'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Pending Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-hourglass-half text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Today's Pending Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['today_pending'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Confirmed Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check text-blue-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Today's Confirmed Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['today_confirmed'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Shipped Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shipping-fast text-purple-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Today's Shipped Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['today_shipped'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Delivered Orders -->
                    {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-box text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Today's Delivered Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['today_delivered'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Today's Cancelled Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Today's Cancelled Orders</dt>
                                        <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $orderStats['today_cancelled'] ?? 0 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts section -->
                <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <!-- Weekly Sales Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Weekly Sales Trend
                            </h3>
                            <div class="mt-4">
                                <canvas id="weeklySalesChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Sales Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Monthly Sales Trend
                            </h3>
                            <div class="mt-4">
                                <canvas id="monthlySalesChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional charts -->
                <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <!-- Top Selling Products (All Time) -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Top Selling
                                Products
                                (All Time)</h3>
                            <div class="mt-4">
                                <canvas id="topProductsChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Top Selling Products -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Top Selling
                                Products
                                (Last 30 Days)</h3>
                            <div class="mt-4">
                                <canvas id="monthlyTopProductsChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order status charts -->
                <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <!-- Order Status Distribution -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Today's Order
                                Status
                            </h3>
                            <div class="mt-4">
                                <canvas id="orderStatusChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Orders Summary -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Today's Orders
                                Summary</h3>
                            <div class="mt-4">
                                <canvas id="dailyOrdersChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Weekly Sales Chart (Line Chart)
                    const weeklySalesCtx = document.getElementById('weeklySalesChart').getContext('2d');
                    const weeklySalesChart = new Chart(weeklySalesCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($weeklySales->keys()) !!},
                            datasets: [{
                                label: 'Daily Sales ($)',
                                data: {!! json_encode($weeklySales->values()) !!},
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Monthly Sales Chart (Line Chart)
                    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
                    const monthlySalesChart = new Chart(monthlySalesCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($monthlySales->keys()) !!},
                            datasets: [{
                                label: 'Daily Sales ($)',
                                data: {!! json_encode($monthlySales->values()) !!},
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Order Status Distribution (Pie Chart)
                    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
                    const orderStatusChart = new Chart(orderStatusCtx, {
                        type: 'pie',
                        data: {
                            labels: {!! json_encode($orderStatusDistribution->keys()) !!},
                            datasets: [{
                                data: {!! json_encode($orderStatusDistribution->values()) !!},
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)',
                                    'rgba(255, 159, 64, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right',
                                }
                            }
                        }
                    });

                    // Top Selling Products (Bar Chart)
                    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
                    const topProductsChart = new Chart(topProductsCtx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($topProducts->pluck('name')) !!},
                            datasets: [{
                                label: 'Number of Orders',
                                data: {!! json_encode($topProducts->pluck('orders_count')) !!},
                                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            indexAxis: 'y'
                        }
                    });

                    // Monthly Top Selling Products (Bar Chart)
                    const monthlyTopProductsCtx = document.getElementById('monthlyTopProductsChart').getContext('2d');
                    const monthlyTopProductsChart = new Chart(monthlyTopProductsCtx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($monthlyTopProducts->pluck('name')) !!},
                            datasets: [{
                                label: 'Number of Orders (Last 30 Days)',
                                data: {!! json_encode($monthlyTopProducts->pluck('orders_count')) !!},
                                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            indexAxis: 'y'
                        }
                    });

                    // Today's Orders Summary (Bar Chart)
                    const dailyOrdersCtx = document.getElementById('dailyOrdersChart').getContext('2d');
                    const dailyOrdersChart = new Chart(dailyOrdersCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Total', 'Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
                            datasets: [{
                                label: 'Orders',
                                data: [
                                    {{ $orderStats['today'] ?? 0 }},
                                    {{ $orderStats['today_pending'] ?? 0 }},
                                    {{ $orderStats['today_processing'] ?? 0 }},
                                    {{ $orderStats['today_shipped'] ?? 0 }},
                                    {{ $orderStats['today_delivered'] ?? 0 }},
                                    {{ $orderStats['today_cancelled'] ?? 0 }}
                                ],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(255, 99, 132, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
        @endpush
    </x-slot>
</x-admin-layout>
