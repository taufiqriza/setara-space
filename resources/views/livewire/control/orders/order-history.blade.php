<div class="h-screen flex flex-col overflow-hidden">
    {{-- Header --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Order History</h1>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <div class="relative hidden md:block">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search order # or name..." class="pl-9 pr-4 py-1.5 text-sm bg-gray-100 border-none rounded-lg focus:ring-2 focus:ring-space-500/20 text-gray-700 w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
           {{-- Filters --}}
           <div class="inline-flex bg-gray-100 rounded-lg p-1">
               <button wire:click="$set('filterDate', 'today')" class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200 {{ $filterDate === 'today' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Today</button>
               <button wire:click="$set('filterDate', 'week')" class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200 {{ $filterDate === 'week' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Week</button>
               <button wire:click="$set('filterDate', 'month')" class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200 {{ $filterDate === 'month' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Month</button>
           </div>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">
        {{-- Mini Analytics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Total Revenue --}}
            <div class="bg-gradient-to-br from-green-600 to-emerald-800 rounded-2xl p-6 text-white shadow-xl shadow-green-500/20 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-md group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-coins text-white text-lg"></i>
                        </div>
                        <span class="text-green-50 text-sm font-medium">Total Revenue</span>
                    </div>
                    <div class="text-3xl font-bold tracking-tight">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
            </div>

            {{-- Total Orders --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-receipt text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_orders'] }}</div>
                <div class="text-gray-500 text-sm font-medium">Total Transactions</div>
            </div>

            {{-- AVG Ticket --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                 <div class="flex items-center justify-between mb-4">
                     <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</div>
                <div class="text-gray-500 text-sm font-medium">Avg. Order Value</div>
            </div>

             {{-- Top Method --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                 <div class="flex items-center justify-between mb-4">
                     <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-credit-card text-orange-500 text-xl"></i>
                    </div>
                </div>
                <div class="text-xl font-bold text-gray-900 capitalize truncate mb-1">
                    {{ $stats['payment_methods']->payment_method ?? 'N/A' }}
                </div>
                <div class="text-gray-500 text-sm font-medium">Top Payment Method</div>
            </div>
        </div>

        {{-- Search Mobile --}}
         <div class="relative block md:hidden">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search order #..." class="pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-space-500/20 text-gray-700 w-full">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        </div>

        {{-- Order List Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                            <th class="px-6 py-4">Order No</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Payment</th>
                             <th class="px-6 py-4">Cashier</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer_name ?: 'Guest' }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->table->name ?? 'Take Away' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-50 text-blue-600' }}">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 uppercase text-xs font-semibold text-gray-500">
                                    {{ $order->payment_method ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                     <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-space-100 flex items-center justify-center text-[10px] font-bold text-space-700">
                                            {{ substr($order->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <span class="text-sm text-gray-600">{{ $order->user->name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="viewOrder({{ $order->id }})" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="View Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button wire:confirm="Are you sure you want to delete this order? This action checks soft delete." wire:click="deleteOrder({{ $order->id }})" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Delete Order">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-inbox text-gray-300 text-2xl"></i>
                                    </div>
                                    <p>No orders found for this period.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    @if($showDetailModal && $selectedOrder)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" wire:click="closeDetailModal">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden flex flex-col max-h-[90vh]" wire:click.stop>
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">Order Detail</h3>
                        <p class="text-xs text-gray-500">{{ $selectedOrder->order_number }} • {{ $selectedOrder->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <button wire:click="closeDetailModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-400">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Receipt Content --}}
                <div class="overflow-y-auto p-6 bg-white" id="receiptContentHistory">
                      {{-- Thermal Printer Layout --}}
                    <div class="font-mono text-xs leading-relaxed text-gray-900" style="font-family: 'Courier New', Courier, monospace;">
                        <div class="text-center mb-4">
                            <h2 class="font-extrabold text-base uppercase">Setara Space</h2>
                            <p class="text-[10px] text-gray-500">Jl. Soekarno Hatta No. 10</p>
                            <p class="text-[10px] text-gray-500">Malang, Jawa Timur</p>
                        </div>

                        <div class="border-b border-dashed border-gray-400 pb-2 mb-2">
                             <div class="flex justify-between">
                                <span>Date:</span>
                                <span>{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Order:</span>
                                <span>{{ $selectedOrder->order_number }}</span>
                            </div>
                             <div class="flex justify-between">
                                <span>Cashier:</span>
                                <span>{{ $selectedOrder->user->name ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Items --}}
                         <div class="border-b border-dashed border-gray-400 pb-2 mb-2 space-y-1">
                            @foreach($selectedOrder->items as $item)
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div>{{ $item->product_name }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $item->quantity }} x {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Totals --}}
                        <div class="space-y-1 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>{{ number_format($selectedOrder->subtotal, 0, ',', '.') }}</span>
                            </div>
                             @if($selectedOrder->tax_amount > 0)
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>{{ number_format($selectedOrder->tax_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($selectedOrder->discount_amount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span>-{{ number_format($selectedOrder->discount_amount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between font-bold text-sm border-t border-dashed border-gray-400 pt-1 mt-1">
                                <span>TOTAL</span>
                                <span>Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                            </div>
                             <div class="flex justify-between text-[10px] text-gray-500 mt-1">
                                <span>Payment</span>
                                <span class="uppercase">{{ $selectedOrder->payment_method }}</span>
                            </div>
                        </div>
                        
                         <div class="text-center text-[10px] mt-4 pt-2 border-t border-dashed border-gray-400">
                            <p>Thank you for your visit!</p>
                            <p>Please come again.</p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex gap-3">
                    <button onclick="printReceiptHistory('receiptContentHistory')" class="flex-1 py-3 bg-space-800 hover:bg-space-900 text-white font-semibold rounded-xl flex items-center justify-center gap-2 transition-colors shadow-lg">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
        

    @endif
</div>
<script>
    window.printReceiptHistory = function(elementId) {
        const contentDiv = document.getElementById(elementId);
        if (!contentDiv) {
            console.error('Receipt content not found:', elementId);
            return;
        }

        const content = contentDiv.innerHTML;
        const printWindow = window.open('', '', 'width=400,height=600');
        
        if (!printWindow) {
            alert('Please allow popups for this website');
            return;
        }

        printWindow.document.write(`
            <html>
                <head>
                    <title>Print Receipt</title>
                    <style>
                        @media print {
                            @page { margin: 0; size: 58mm auto; }
                            body { margin: 0; padding: 5px; width: 58mm; }
                        }
                        body {
                            font-family: 'Courier New', Courier, monospace;
                            font-size: 11px;
                            color: #000;
                            background: #fff;
                            width: 58mm;
                            margin: 0 auto;
                        }
                        .text-center { text-align: center; }
                        .text-right { text-align: right; }
                        .font-bold { font-weight: bold; }
                        .uppercase { text-transform: uppercase; }
                        .flex { display: flex; justify-content: space-between; }
                        .border-b { border-bottom: 1px dashed #000; margin-bottom: 5px; padding-bottom: 5px; }
                        .border-t { border-top: 1px dashed #000; margin-top: 5px; padding-top: 5px; }
                        .mb-2 { margin-bottom: 8px; }
                        .mb-4 { margin-bottom: 12px; }
                        .text-xs { font-size: 10px; }
                        .text-green-600 { color: #000; }
                    </style>
                </head>
                <body>
                    ${content}
                    <script>
                        setTimeout(() => {
                            window.print();
                            window.close();
                        }, 500);
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>
