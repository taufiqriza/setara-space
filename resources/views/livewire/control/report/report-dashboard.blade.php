<div class="h-screen flex flex-col overflow-hidden bg-gray-50/50">
    {{-- Header --}}
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-30 sticky top-0 w-full shadow-sm">
        <div class="flex items-center gap-4">
             <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors shadow-sm ring-1 ring-gray-200">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Financial Report</h1>
                <p class="text-xs text-gray-500 font-medium">Real-time performance overview</p>
            </div>
        </div>

        {{-- Date Filter & Actions --}}
        <div class="flex items-center gap-3">
             <div class="flex items-center gap-2 bg-gray-100 p-1 rounded-xl">
                @foreach(['today' => 'Today', 'yesterday' => 'Yesterday', 'this_week' => 'Week', 'this_month' => 'Month'] as $key => $label)
                <button wire:click="setDateFilter('{{ $key }}')" 
                    class="px-4 py-1.5 text-sm font-semibold rounded-lg transition-all {{ $dateFilter === $key ? 'bg-white text-space-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>
            
            <div class="h-8 w-px bg-gray-200 mx-1"></div>
            
            <button wire:click="exportPdf" wire:loading.attr="disabled" class="flex items-center gap-2 bg-space-600 hover:bg-space-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-space-200 transition-all">
                <i wire:loading.remove wire:target="exportPdf" class="fas fa-file-pdf"></i>
                <i wire:loading wire:target="exportPdf" class="fas fa-spinner fa-spin"></i>
                <span>Download Report</span>
            </button>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto p-6 scrollbar-hide">
        
        {{-- 1. Mini Dashboard (Key Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-gradient-to-br from-space-600 to-space-700 rounded-2xl p-5 text-white shadow-lg shadow-space-200 transition-transform hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    @if($overview['margin'] > 0)
                    <span class="px-2 py-1 rounded-lg bg-emerald-400/20 text-emerald-100 text-xs font-bold border border-emerald-400/30">
                        +{{ number_format($overview['margin'], 1) }}% Margin
                    </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-white/80 text-sm font-medium">Total Revenue</h3>
                    <p class="text-2xl font-bold mt-1">Rp {{ number_format($overview['revenue'], 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Gross Profit -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                 <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fas fa-coins text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-400">Actual</span>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Gross Profit</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($overview['gross_profit'], 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Revenue - COGS</p>
                </div>
            </div>

            <!-- Orders Count -->
             <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                 <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-lg"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Total Orders</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($overview['orders']) }}</p>
                </div>
            </div>

             <!-- Avg Order Value -->
             <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                 <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                        <i class="fas fa-chart-line text-lg"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Avg. Order Value</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($overview['avg_order'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- 2. Sales Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6"
                 x-data="salesChart({!! json_encode($chartData) !!})">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Sales Analytics</h3>
                <div class="h-64 relative">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>

            {{-- 3. Top Products --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Top Products</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">
                                {{ substr($product->product_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-space-600 transition-colors">{{ \Illuminate\Support\Str::limit($product->product_name, 15) }}</p>
                                <p class="text-xs text-gray-500">{{ $product->total_qty }} sold</p>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-gray-900">
                           {{ number_format($product->total_revenue, 0, ',', '.') }}
                        </p>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400 text-sm">No sales yet</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- 4. Compact Breakdown Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
             <!-- Payment Methods -->
             <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900">Payment Breakdown</h3>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Transactions</span>
                </div>
                <div class="space-y-2">
                    @forelse($paymentMethods as $method)
                    @php
                        $methodName = match($method->payment_method) {
                            'cash' => 'Cash Payment',
                            'qris' => 'QRIS Transfer',
                            'debit' => 'Debit Card',
                            'credit' => 'Credit Card',
                            default => ucwords(str_replace('_', ' ', $method->payment_method))
                        };
                        
                        $methodIcon = match($method->payment_method) {
                            'cash' => 'fa-money-bill-wave',
                            'qris' => 'fa-qrcode',
                            'debit' => 'fa-credit-card',
                            'credit' => 'fa-cc-visa',
                            default => 'fa-wallet'
                        };
                        
                        $iconColor = match($method->payment_method) {
                            'cash' => 'text-green-600 bg-green-50',
                            'qris' => 'text-blue-600 bg-blue-50',
                            'debit' => 'text-orange-600 bg-orange-50',
                            default => 'text-indigo-600 bg-indigo-50'
                        };
                    @endphp
                    <div class="flex items-center justify-between p-2.5 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $iconColor }} flex items-center justify-center text-xs shadow-sm group-hover:scale-110 transition-transform">
                                <i class="fas {{ $methodIcon }}"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">{{ $methodName }}</p>
                                <p class="text-[10px] text-gray-400">Total: Rp {{ number_format($method->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ $method->total }} <span class="text-[10px] font-normal text-gray-400">Trx</span></span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-xs text-gray-400">No payment data</div>
                    @endforelse
                </div>
            </div>
            
            <!-- Profitability Compact -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900">Profitability Analysis</h3>
                    @if($overview['margin'] != 0)
                        <span class="text-xs font-bold {{ $overview['margin'] > 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full">
                            {{ number_format($overview['margin'], 1) }}% Margin
                        </span>
                    @endif
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Gross Revenue</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($overview['revenue'], 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 flex items-center gap-1"><i class="fas fa-minus-circle text-red-300 text-xs"></i> COGS (Estimated)</span>
                        <span class="font-bold text-red-600">- Rp {{ number_format($overview['cogs'], 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="h-px bg-gray-100 w-full my-1"></div>
                    
                    <div class="flex justify-between items-end p-3 rounded-xl bg-gradient-to-r from-space-50 to-white border border-space-100">
                        <div>
                            <span class="block text-xs text-space-600 font-bold uppercase tracking-wider mb-1">Net Profit</span>
                            <span class="text-2xl font-black text-space-700">Rp {{ number_format($overview['gross_profit'], 0, ',', '.') }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-space-100 text-space-600 flex items-center justify-center">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Chart Script --}}
    {{-- Chart Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('salesChart', (initialData) => ({
                chart: null,
                init() {
                    // Wait for Chart.js
                    if (typeof Chart === 'undefined') {
                        setTimeout(() => this.init(), 100);
                        return;
                    }
                    this.renderChart(initialData);

                    // Listen for updates
                    // We use $wire.on shorthand if possible, but global Livewire.on is safer here
                    Livewire.on('chart-update', (data) => {
                        // Unpack data: Livewire often wraps args in array
                        const payload = Array.isArray(data) ? data[0] : data;
                        this.updateChart(payload);
                    });
                },
                renderChart(data) {
                    const ctx = this.$refs.canvas.getContext('2d');
                    const chartData = Array.isArray(data) ? data : Object.values(data);
                    const labels = chartData.map(item => item.label);
                    const values = chartData.map(item => item.value);

                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(91, 61, 239, 0.2)');
                    gradient.addColorStop(1, 'rgba(91, 61, 239, 0)');

                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Revenue',
                                data: values,
                                borderColor: '#5b3def',
                                backgroundColor: gradient,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#5b3def',
                                pointBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1f2937',
                                    titleFont: { family: 'Outfit', size: 13 },
                                    bodyFont: { family: 'Outfit', size: 14, weight: 'bold' },
                                    padding: 12,
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: (context) => 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y)
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#f3f4f6', borderDash: [5, 5] },
                                    ticks: {
                                        font: { family: 'Outfit', size: 11 },
                                        color: '#9ca3af',
                                        callback: (value) => 'Rp ' + (value / 1000) + 'k'
                                    },
                                    border: { display: false }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { family: 'Outfit', size: 11 }, color: '#9ca3af' },
                                    border: { display: false }
                                }
                            }
                        }
                    });
                },
                updateChart(data) {
                    if (this.chart) {
                        const chartData = Array.isArray(data) ? data : Object.values(data);
                        this.chart.data.labels = chartData.map(item => item.label);
                        this.chart.data.datasets[0].data = chartData.map(item => item.value);
                        this.chart.update();
                    } else {
                        this.renderChart(data);
                    }
                }
            }));
        });
    </script>
</div>
