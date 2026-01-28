<div class="h-screen flex flex-col overflow-hidden" wire:poll.30s>
    
    {{-- Header Section --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0 z-10">
        <div class="flex items-center gap-4">
             <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    Dashboard <span class="text-xs font-normal text-gray-400 border border-gray-200 px-2 py-0.5 rounded-full hidden sm:inline-block">v1.0</span>
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
             <div class="hidden sm:flex items-center gap-2 text-xs font-medium text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                <i class="far fa-clock"></i>
                <span>{{ now()->format('D, d M Y') }}</span>
            </div>
            <a href="{{ route('control.pos') }}" class="px-3 py-1.5 bg-space-800 hover:bg-space-900 text-white text-xs sm:text-sm font-semibold rounded-lg shadow-lg transition-transform active:scale-95 flex items-center gap-2">
                <i class="fas fa-cash-register"></i> <span class="hidden sm:inline">Open POS</span>
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">
        
        {{-- Welcome Banner --}}
        <div class="bg-gradient-to-r from-space-900 to-space-800 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
             <div class="relative z-10">
                <h2 class="text-2xl font-bold">{{ $greeting }}, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-space-200 text-sm mt-1 max-w-xl">Welcome back to Setara Space Control Panel. Here's your store performance overview for today.</p>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-10"></div>
            <div class="absolute right-20 bottom-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-10"></div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Revenue -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-space-200 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Revenue Today</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($metrics['revenue'] ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <i class="fas fa-coins text-lg"></i>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: 70%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-2 text-right">Target daily achievement</p>
            </div>

            <!-- Orders -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-space-200 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Orders</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $metrics['orders_count'] ?? 0 }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-lg"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs text-blue-600 bg-blue-50 w-fit px-2 py-0.5 rounded-md font-medium">
                    <i class="fas fa-box"></i> {{ $metrics['items_sold'] ?? 0 }} Items Sold
                </div>
            </div>

            <!-- Active Orders -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-space-200 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kitchen Status</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $metrics['active_orders'] ?? 0 }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center animate-pulse">
                        <i class="fas fa-fire-burner text-lg"></i>
                    </div>
                </div>
                <div class="text-xs font-medium {{ $metrics['active_orders'] > 0 ? 'text-red-500' : 'text-green-500' }}">
                    {{ $metrics['active_orders'] > 0 ? 'Orders need attention' : 'Kitchen is idle' }}
                </div>
            </div>

            <!-- Avg Value -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-space-200 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Avg. Order</p>
                         @php $avg = $metrics['orders_count'] > 0 ? $metrics['revenue'] / $metrics['orders_count'] : 0; @endphp
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($avg, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i class="fas fa-chart-line text-lg"></i>
                    </div>
                </div>
                <div class="text-xs text-gray-400">Based on today's transactions</div>
            </div>
        </div>

        {{-- Analytics Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sales Chart -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                 <div class="flex items-center justify-between mb-6">
                    <div>
                         <h3 class="font-bold text-gray-900">Revenue Trend</h3>
                         <p class="text-sm text-gray-500">Last 7 Days Performance</p>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="w-2 h-2 rounded-full bg-space-600"></span> Current Week
                        </div>
                    </div>
                </div>
                
                {{-- Chart Container --}}
                <div wire:ignore class="w-full relative" style="min-height: 300px;">
                    <div id="revenueChart" class="w-full h-[300px]"></div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col h-[420px]">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-crown text-amber-500"></i> Top Items Today
                </h3>
                <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4">
                    @forelse($topProducts as $index => $item)
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="w-8 h-8 rounded-full {{ $index == 0 ? 'bg-amber-100 text-amber-600' : ($index == 1 ? 'bg-gray-200 text-gray-600' : ($index == 2 ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-500')) }} font-bold flex items-center justify-center flex-shrink-0 text-xs shadow-sm">
                            #{{ $index + 1 }}
                        </div>
                        
                        @if(optional($item->product)->image)
                            <img src="{{ Storage::url($item->product->image) }}" class="w-10 h-10 rounded-lg object-cover" alt="">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ optional($item->product)->name ?? 'Unknown Product' }}</p>
                            <p class="text-[10px] text-gray-500">{{ optional($item->product)->category->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">{{ $item->total_qty }}</p>
                            <p class="text-[10px] text-gray-400">sold</p>
                        </div>
                    </div>
                    @empty
                    <div class="h-full flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-ghost text-4xl mb-3 opacity-20"></i>
                        <p class="text-sm">No sales yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Orders Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Recent Transactions</h3>
                <a href="{{ route('control.orders') }}" class="text-sm text-space-600 hover:text-space-800 font-medium hover:underline">See All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
                            <th class="px-6 py-4 font-medium uppercase text-xs tracking-wider">#Order</th>
                            <th class="px-6 py-4 font-medium uppercase text-xs tracking-wider">Customer</th>
                            <th class="px-6 py-4 font-medium uppercase text-xs tracking-wider">Status</th>
                            <th class="px-6 py-4 font-medium uppercase text-xs tracking-wider">Amount</th>
                            <th class="px-6 py-4 font-medium uppercase text-xs tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 font-mono font-medium text-gray-700">
                                <span class="bg-gray-100 px-2 py-0.5 rounded text-xs">#{{ substr($order->order_number, -4) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $order->customer_name ?: 'Guest' }}</p>
                                <p class="text-xs text-gray-500">{{ $order->table->name ?? 'Take Away' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border
                                    {{ $order->status === 'completed' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-blue-50 text-blue-600 border-blue-200' }}">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $order->created_at->format('H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No transactions recorded today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', () => {
        initDashboardChart();
    });

    // Also run on first load (if direct link)
    document.addEventListener('DOMContentLoaded', () => {
        initDashboardChart();
    });

    function initDashboardChart() {
        if (!window.ApexCharts) {
            console.warn('ApexCharts not loaded');
            return;
        }

        const chartElement = document.querySelector("#revenueChart");
        
        // Prevent re-init if already exists (check if has children or chart instance)
        if (!chartElement || chartElement.innerHTML.trim() !== "") return; 

        // Data passing from Blade
        const rawData = @json($chartData);
        const categories = rawData.map(item => item.date);
        const seriesData = rawData.map(item => item.revenue);

        const options = {
            series: [{
                name: 'Revenue',
                data: seriesData
            }],
            chart: {
                type: 'area',
                height: 300,
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: { 
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: ['#4f46e5'], // space-600
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.6,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#4f46e5']
            },
            xaxis: {
                categories: categories,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#9ca3af', fontSize: '11px', fontFamily: 'Inter' }
                },
                tooltip: { enabled: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '11px', fontFamily: 'Inter' },
                    formatter: (value) => {
                        if(value >= 1000000) return (value/1000000).toFixed(1) + 'M';
                        if(value >= 1000) return (value/1000).toFixed(0) + 'k';
                        return value;
                    }
                }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
                xaxis: { lines: { show: false } }, 
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                },
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter'
                },
                marker: { show: true },
            },
            markers: {
                size: 0,
                hover: { size: 5 }
            }
        };

        const chart = new ApexCharts(chartElement, options);
        chart.render();
    }
</script>
