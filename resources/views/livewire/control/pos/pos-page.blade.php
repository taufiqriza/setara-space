<div class="h-screen flex flex-col overflow-hidden">
    
    {{-- Header Bar --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
        {{-- Left: Menu & Date & Cashier --}}
        <div class="flex items-center gap-3">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
                <i class="far fa-calendar"></i>
                <span>{{ now()->format('D, d M Y') }}</span>
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->name ?? 'Kasir' }}</span>
            </div>
        </div>
        
        {{-- Center: Order Status --}}
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full {{ count($cartItems) > 0 ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
            <span class="text-sm font-medium {{ count($cartItems) > 0 ? 'text-green-600' : 'text-gray-500' }}">
                {{ count($cartItems) > 0 ? 'Open Order' : 'No Order' }}
            </span>
            @if(count($cartItems) > 0)
                <span class="text-xs text-gray-400">({{ count($cartItems) }} items)</span>
            @endif
        </div>
        
        {{-- Right: Time & Refresh --}}
        <div class="flex items-center gap-2">
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
                <i class="far fa-clock"></i>
                <span x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}), 1000)" x-text="time"></span>
            </div>
            <button wire:click="$refresh" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-500">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </header>
    
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mx-4 mt-2 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mx-4 mt-2 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-xl flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Content --}}
    <div class="flex-1 flex overflow-hidden">
        
        {{-- LEFT: Product Grid --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-gradient-to-br from-slate-50 to-blue-50/50">
            
            {{-- Category Tabs - Fixed size cards with horizontal scroll --}}
            <div class="px-4 pt-4 pb-2 flex-shrink-0">
                <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2 -mx-1 px-1">
                    {{-- All Menu --}}
                    <button wire:click="selectCategory('all')" 
                            class="flex flex-col items-center justify-center w-20 h-20 flex-shrink-0 rounded-xl border-2 transition-all {{ !$selectedCategory ? 'bg-space-800 text-white border-space-800 shadow-lg' : 'bg-white text-gray-600 border-gray-200 hover:border-space-300 hover:shadow' }}">
                        <i class="fas fa-th-large text-lg mb-1"></i>
                        <span class="text-[10px] font-medium">All</span>
                        <span class="text-[9px] opacity-70">{{ $products->count() }}</span>
                    </button>
                    
                    {{-- Categories --}}
                    @foreach($categories as $category)
                        <button wire:click="selectCategory({{ $category->id }})" 
                                class="flex flex-col items-center justify-center w-20 h-20 flex-shrink-0 rounded-xl border-2 transition-all {{ $selectedCategory === $category->id ? 'bg-space-800 text-white border-space-800 shadow-lg' : 'bg-white text-gray-600 border-gray-200 hover:border-space-300 hover:shadow' }}">
                            <i class="{{ $category->icon ?? 'fas fa-bowl-food' }} text-lg mb-1"></i>
                            <span class="text-[10px] font-medium truncate max-w-[60px]">{{ $category->name }}</span>
                            <span class="text-[9px] opacity-70">{{ $category->products_count }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
            
            {{-- Search Bar --}}
            <div class="px-4 pb-3 flex-shrink-0">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none text-gray-700 text-sm">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            
            {{-- Product Grid --}}
            <div class="flex-1 overflow-y-auto px-4 pb-4">
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                        @foreach($products as $product)
                            <div wire:click="openProductModal({{ $product->id }})" 
                                 class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-lg transition-all cursor-pointer group border border-transparent hover:border-space-200">
                                {{-- Image --}}
                                <div class="aspect-square bg-gray-100 rounded-xl mb-2 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <i class="fas fa-bowl-food text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Info --}}
                                <h3 class="font-medium text-gray-900 text-sm mb-1 truncate">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-space-700 text-sm">Rp {{ number_format($product->price/1000, 0) }}K</span>
                                    <button wire:click.stop="quickAddToCart({{ $product->id }})" 
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-space-100 text-space-600 hover:bg-space-600 hover:text-white transition-colors">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                        <i class="fas fa-box-open text-5xl mb-3"></i>
                        <p class="font-medium">Belum ada produk</p>
                        <p class="text-sm">Tambahkan produk di menu Products</p>
                    </div>
                @endif
            </div>
        </div>
        
        {{-- RIGHT: Order Panel --}}
        <div class="w-80 lg:w-96 bg-white border-l border-gray-200 flex flex-col overflow-hidden flex-shrink-0">
            
            {{-- Order Header --}}
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-receipt text-space-600"></i>
                        <span class="text-sm font-semibold text-gray-900">{{ $currentOrderNumber }}</span>
                    </div>
                    @if(count($cartItems) > 0)
                        <button wire:click="clearCart" class="text-xs text-red-500 hover:text-red-600 font-medium">
                            <i class="fas fa-trash mr-1"></i>Clear
                        </button>
                    @endif
                </div>
                
                {{-- Customer Name --}}
                <input type="text" 
                       wire:model="customerName" 
                       placeholder="Customer's Name" 
                       class="w-full text-lg font-semibold text-gray-900 placeholder:text-gray-300 border-none p-0 focus:ring-0 outline-none bg-transparent mb-3">
                
                {{-- Table & Order Type --}}
                <div class="flex gap-2">
                    <select wire:model="tableId" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
                        <option value="">Select Table</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model="orderType" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
                        <option value="dine_in">Dine In</option>
                        <option value="take_away">Take Away</option>
                    </select>
                </div>
            </div>
            
            {{-- Cart Items --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-2">
                @forelse($cartItems as $index => $item)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl group">
                        {{-- Thumbnail --}}
                        <div class="w-12 h-12 bg-white rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fas fa-bowl-food text-sm"></i>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-900 text-sm truncate">{{ $item['name'] }}</h4>
                            <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            @if($item['notes'])
                                <p class="text-xs text-space-600 truncate"><i class="fas fa-sticky-note mr-1"></i>{{ $item['notes'] }}</p>
                            @endif
                        </div>
                        
                        {{-- Quantity --}}
                        <div class="flex items-center gap-1">
                            <button wire:click="decrementCartItem({{ $index }})" class="w-6 h-6 flex items-center justify-center rounded-md bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-red-500 text-xs">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="w-6 text-center font-medium text-sm">{{ $item['quantity'] }}</span>
                            <button wire:click="incrementCartItem({{ $index }})" class="w-6 h-6 flex items-center justify-center rounded-md bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-green-500 text-xs">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                        <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                        <p class="text-sm">No Item Selected</p>
                        <p class="text-xs">Tap product to add</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Order Summary --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{-- Totals --}}
                <div class="space-y-1.5 mb-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax ({{ $taxRate }}%)</span>
                        <span class="font-medium">Rp {{ number_format($taxAmount, 0, ',', '.') }}</span>
                    </div>
                    @if($discountAmount > 0)
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Discount</span>
                            <span class="font-medium">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                        <span>TOTAL</span>
                        <span class="text-space-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                {{-- Payment Method --}}
                <div class="flex gap-2 mb-3">
                    <button wire:click="selectPaymentMethod('cash')" class="flex-1 py-2.5 rounded-lg text-sm font-medium transition-all {{ $paymentMethod === 'cash' ? 'bg-green-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <i class="fas fa-money-bill mr-1"></i> Cash
                    </button>
                    <button wire:click="selectPaymentMethod('qris')" class="flex-1 py-2.5 rounded-lg text-sm font-medium transition-all {{ $paymentMethod === 'qris' ? 'bg-teal-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <i class="fas fa-qrcode mr-1"></i> QRIS
                    </button>
                </div>
                
                {{-- Place Order Button --}}
                <button wire:click="placeOrder" 
                        class="w-full py-3.5 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-70"
                        {{ count($cartItems) == 0 ? 'disabled' : '' }}>
                    <span wire:loading.remove wire:target="placeOrder">
                        <i class="fas fa-check-circle"></i>
                        Place Order
                    </span>
                    <span wire:loading wire:target="placeOrder">
                        <i class="fas fa-spinner fa-spin"></i>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Track Order Bar (Bottom) --}}
    @if($recentOrders->count() > 0)
        <div class="h-28 bg-white border-t border-gray-200 flex flex-col flex-shrink-0">
            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-gray-900">Active Orders</span>
                    <span class="px-2 py-0.5 bg-space-100 text-space-600 text-xs font-medium rounded-full">{{ $recentOrders->count() }}</span>
                </div>
                <a href="{{ route('control.activity') }}" wire:navigate class="text-xs text-space-600 hover:text-space-700 font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="flex-1 overflow-x-auto scrollbar-hide px-4 py-2">
                <div class="flex gap-3 h-full">
                    @foreach($recentOrders as $order)
                        <div wire:click="viewOrder({{ $order->id }})" 
                             class="min-w-[160px] bg-gray-50 rounded-xl p-3 border border-gray-100 hover:border-space-300 cursor-pointer transition-all flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-semibold text-gray-900 text-sm">{{ $order->customer_name ?: 'Guest' }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded-full font-medium
                                    {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $order->status === 'on_kitchen' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $order->status === 'all_done' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $order->status === 'to_be_served' ? 'bg-purple-100 text-purple-700' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 flex items-center gap-2">
                                <span>{{ $order->table->name ?? 'Take Away' }}</span>
                                <span>•</span>
                                <span>{{ $order->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    {{-- Product Detail Modal --}}
    @if($showProductModal && $selectedProduct)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden max-h-[85vh] flex flex-col" wire:click.stop>
                {{-- Close Button --}}
                <div class="flex justify-between items-center p-4 border-b border-gray-100 flex-shrink-0">
                    <span class="font-semibold text-gray-900">Detail Menu</span>
                    <button wire:click="closeProductModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                {{-- Scrollable Content --}}
                <div class="flex-1 overflow-y-auto">
                    {{-- Product Image --}}
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        @if($selectedProduct['image'])
                            <img src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fas fa-bowl-food text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Product Info --}}
                    <div class="p-4">
                        <span class="text-xs text-space-600 bg-space-50 px-2 py-0.5 rounded-full">{{ $selectedProduct['category'] }}</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $selectedProduct['name'] }}</h3>
                        @if($selectedProduct['description'])
                            <p class="text-sm text-gray-500 mt-1">{{ $selectedProduct['description'] }}</p>
                        @endif
                        <p class="text-2xl font-bold text-space-600 mt-3">Rp {{ number_format($selectedProduct['price'], 0, ',', '.') }}</p>
                        
                        {{-- Notes --}}
                        <div class="mt-4">
                            <label class="text-xs text-gray-500 font-medium mb-1 block">Notes (optional)</label>
                            <textarea wire:model="modalNotes" placeholder="Add notes to your order..." rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none resize-none"></textarea>
                        </div>
                        
                        {{-- Quantity --}}
                        <div class="flex items-center justify-center gap-4 mt-4 py-3 bg-gray-50 rounded-xl">
                            <button wire:click="decrementModalQty" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="text-2xl font-bold w-12 text-center">{{ $modalQuantity }}</span>
                            <button wire:click="incrementModalQty" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Add to Cart Button - Fixed at bottom --}}
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex-shrink-0">
                    <button wire:click="addToCart" class="w-full py-3.5 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                        <i class="fas fa-cart-plus mr-2"></i>
                        Add to Cart - Rp {{ number_format($selectedProduct['price'] * $modalQuantity, 0, ',', '.') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
    
    {{-- Print Receipt Modal --}}
    @if($showReceiptModal && $lastOrder)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" wire:click.stop>
                {{-- Header --}}
                <div class="p-4 text-center border-b border-dashed border-gray-300">
                    <i class="fas fa-check-circle text-green-500 text-4xl mb-2"></i>
                    <h3 class="font-bold text-lg text-gray-900">Order Created!</h3>
                    <p class="text-gray-500 text-sm">{{ $lastOrder['order_number'] }}</p>
                </div>
                
                {{-- Receipt Preview --}}
                <div class="p-4 text-sm" id="receiptContent">
                    <div class="text-center mb-3">
                        <h4 class="font-bold">SETARA SPACE</h4>
                        <p class="text-xs text-gray-500">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-300 py-2">
                        <p><strong>{{ $lastOrder['customer_name'] ?: 'Guest' }}</strong></p>
                        <p class="text-xs text-gray-500">{{ $lastOrder['table_name'] ?? 'Take Away' }} • {{ ucfirst(str_replace('_', ' ', $lastOrder['order_type'])) }}</p>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-300 py-2 space-y-1">
                        @foreach($lastOrder['items'] as $item)
                            <div class="flex justify-between">
                                <span>{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                                <span>{{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-dashed border-gray-300 py-2 space-y-1">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>{{ number_format($lastOrder['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>{{ number_format($lastOrder['tax_amount'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-base pt-1">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($lastOrder['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-300 py-2 text-center">
                        <p class="text-gray-500">Payment: {{ ucfirst($lastOrder['payment_method']) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Thank you for your order!</p>
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="p-4 bg-gray-50 flex gap-2">
                    <button wire:click="closeReceiptModal" class="flex-1 py-2.5 text-gray-600 hover:bg-gray-200 font-medium rounded-xl">
                        Close
                    </button>
                    <button onclick="printReceipt()" class="flex-1 py-2.5 bg-space-600 hover:bg-space-700 text-white font-medium rounded-xl">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            function printReceipt() {
                const content = document.getElementById('receiptContent');
                const printWindow = window.open('', '', 'width=300,height=600');
                printWindow.document.write('<html><head><title>Receipt</title>');
                printWindow.document.write('<style>body{font-family:monospace;font-size:12px;padding:10px;} .flex{display:flex;justify-content:space-between;}</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(content.innerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }
        </script>
    @endif

    {{-- Order Detail / Status Modal --}}
    @if($showOrderDetailModal && $selectedOrder)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" wire:click.stop>
                {{-- Header --}}
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $selectedOrder->order_number }}</h3>
                        <p class="text-xs text-gray-500">{{ $selectedOrder->customer_name ?: 'Guest' }} • {{ $selectedOrder->table->name ?? 'Take Away' }}</p>
                    </div>
                    <button wire:click="closeOrderDetailModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-400">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                {{-- Items --}}
                <div class="p-4 max-h-[300px] overflow-y-auto">
                    <div class="space-y-3">
                        @foreach($selectedOrder->items as $item)
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded bg-space-100 text-space-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ $item->quantity }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                                @if($item->notes)
                                    <p class="text-xs text-gray-500 italic">"{{ $item->notes }}"</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                {{-- Status Change Actions --}}
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-3 text-center">Update Status</p>
                    
                    <div class="grid grid-cols-2 gap-2">
                        @if($selectedOrder->status === 'pending')
                            <button wire:click="updateOrderStatus('on_kitchen')" class="col-span-2 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                                <i class="fas fa-fire-burner"></i> Process to Kitchen
                            </button>
                        @elseif($selectedOrder->status === 'on_kitchen')
                            <button wire:click="updateOrderStatus('to_be_served')" class="col-span-2 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                                <i class="fas fa-bell-concierge"></i> Order Ready to Serve
                            </button>
                        @elseif($selectedOrder->status === 'to_be_served')
                            <button wire:click="updateOrderStatus('all_done')" class="col-span-2 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                                <i class="fas fa-check-double"></i> Complete Order
                            </button>
                        @endif
                    </div>
                    
                    <div class="mt-2 text-center">
                        <span class="text-xs text-gray-400">Current Status: {{ ucfirst(str_replace('_', ' ', $selectedOrder->status)) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
