<div class="h-screen flex flex-col overflow-hidden">
    
    {{-- Header Bar --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
        {{-- Left: Menu & Date --}}
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
                <i class="far fa-calendar"></i>
                <span>{{ now()->format('D, d M Y') }}</span>
            </div>
            <div class="hidden sm:flex items-center gap-3 text-gray-400">
                <span>—</span>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
                <i class="far fa-clock"></i>
                <span x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}), 1000)" x-text="time"></span>
            </div>
        </div>
        
        {{-- Center: Order Status --}}
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full {{ count($cartItems) > 0 ? 'bg-green-500' : 'bg-gray-400' }}"></span>
            <span class="text-sm font-medium {{ count($cartItems) > 0 ? 'text-green-600' : 'text-gray-500' }}">
                {{ count($cartItems) > 0 ? '● Open Order' : '● Close Order' }}
            </span>
        </div>
        
        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">
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
            
            {{-- Category Tabs --}}
            <div class="px-4 pt-4 pb-2 flex-shrink-0">
                <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
                    {{-- All Menu --}}
                    <button wire:click="selectCategory('all')" 
                            class="flex flex-col items-center gap-1 min-w-[80px] p-3 rounded-xl border-2 transition-all {{ !$selectedCategory ? 'bg-space-800 text-white border-space-800' : 'bg-white text-gray-600 border-gray-200 hover:border-space-300' }}">
                        <i class="fas fa-th-large text-lg"></i>
                        <span class="text-xs font-medium whitespace-nowrap">All Menu</span>
                        <span class="text-[10px] opacity-70">{{ $products->count() }} Items</span>
                    </button>
                    
                    {{-- Categories --}}
                    @foreach($categories as $category)
                        <button wire:click="selectCategory({{ $category->id }})" 
                                class="flex flex-col items-center gap-1 min-w-[80px] p-3 rounded-xl border-2 transition-all {{ $selectedCategory === $category->id ? 'bg-space-800 text-white border-space-800' : 'bg-white text-gray-600 border-gray-200 hover:border-space-300' }}">
                            <i class="{{ $category->icon ?? 'fas fa-bowl-food' }} text-lg"></i>
                            <span class="text-xs font-medium whitespace-nowrap">{{ $category->name }}</span>
                            <span class="text-[10px] opacity-70">{{ $category->products_count }} Items</span>
                        </button>
                    @endforeach
                </div>
            </div>
            
            {{-- Search Bar --}}
            <div class="px-4 pb-4 flex-shrink-0">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none text-gray-700">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            
            {{-- Product Grid --}}
            <div class="flex-1 overflow-y-auto px-4 pb-4">
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($products as $product)
                            <div wire:click="openProductModal({{ $product->id }})" 
                                 class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-lg transition-all cursor-pointer group border border-transparent hover:border-space-200">
                                {{-- Image --}}
                                <div class="aspect-square bg-gray-100 rounded-xl mb-2 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <i class="fas fa-bowl-food text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Info --}}
                                <h3 class="font-medium text-gray-900 text-sm mb-1 truncate">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-space-600 bg-space-50 px-2 py-0.5 rounded-full">{{ $product->category->name ?? '-' }}</span>
                                    <span class="font-semibold text-gray-900 text-sm">Rp{{ number_format($product->price/1000, 0) }}K</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                        <i class="fas fa-box-open text-5xl mb-3"></i>
                        <p class="font-medium">Belum ada produk</p>
                        <p class="text-sm">Tambahkan produk di menu Inventory</p>
                    </div>
                @endif
            </div>
        </div>
        
        {{-- RIGHT: Order Panel --}}
        <div class="w-80 lg:w-96 bg-white border-l border-gray-200 flex flex-col overflow-hidden flex-shrink-0">
            
            {{-- Order Header --}}
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-receipt text-gray-400"></i>
                        <span class="text-gray-400 text-sm">Order Number</span>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-pen text-sm"></i>
                    </button>
                </div>
                
                {{-- Customer Name --}}
                <input type="text" 
                       wire:model="customerName" 
                       placeholder="Customer's Name" 
                       class="w-full text-xl font-semibold text-gray-900 placeholder:text-gray-300 border-none p-0 focus:ring-0 outline-none bg-transparent">
                
                {{-- Table & Order Type --}}
                <div class="flex gap-2 mt-3">
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
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @forelse($cartItems as $index => $item)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl group">
                        {{-- Thumbnail --}}
                        <div class="w-14 h-14 bg-white rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fas fa-bowl-food"></i>
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
                            <button wire:click="decrementCartItem({{ $index }})" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-red-500">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="w-7 text-center font-medium text-sm">{{ $item['quantity'] }}</span>
                            <button wire:click="incrementCartItem({{ $index }})" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-green-500">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                        <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                        <p class="text-sm">No Item Selected</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Order Summary --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{-- Totals --}}
                <div class="space-y-2 mb-4">
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
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                {{-- Promo & Payment --}}
                <div class="flex gap-2 mb-4">
                    <div class="flex-1 relative">
                        <input type="text" wire:model="promoCode" placeholder="Add Promo or Voucher" class="w-full px-3 py-2 pr-10 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-space-600">
                            <i class="fas fa-tag"></i>
                        </button>
                    </div>
                    <div class="flex gap-1">
                        <button wire:click="selectPaymentMethod('cash')" class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ $paymentMethod === 'cash' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Cash
                        </button>
                        <button wire:click="selectPaymentMethod('qris')" class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ $paymentMethod === 'qris' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            QRIS
                        </button>
                    </div>
                </div>
                
                {{-- Place Order Button --}}
                <button wire:click="placeOrder" 
                        class="w-full py-4 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-70">
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
        <div class="h-24 bg-white border-t border-gray-200 flex items-center px-4 flex-shrink-0">
            <div class="flex items-center gap-2 mr-4">
                <span class="text-sm font-medium text-gray-600">Track Order</span>
                <span class="px-2 py-0.5 bg-space-100 text-space-600 text-xs rounded-full">{{ $recentOrders->count() }}</span>
            </div>
            <div class="flex-1 overflow-x-auto scrollbar-hide">
                <div class="flex gap-3">
                    @foreach($recentOrders as $order)
                        <div class="min-w-[180px] bg-gray-50 rounded-xl p-3 border border-gray-100 hover:border-space-300 cursor-pointer transition-all">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-semibold text-gray-900 text-sm">{{ $order->customer_name ?: 'Guest' }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded-full 
                                    {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $order->status === 'on_kitchen' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $order->status === 'all_done' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $order->status === 'to_be_served' ? 'bg-purple-100 text-purple-700' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $order->table->name ?? 'Take Away' }} • {{ $order->order_type === 'dine_in' ? 'Dine In' : 'Take Away' }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('H:i') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    {{-- Product Detail Modal --}}
    @if($showProductModal && $selectedProduct)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeProductModal">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" @click.stop>
                {{-- Close Button --}}
                <div class="flex justify-between items-center p-4 border-b border-gray-100">
                    <span class="font-semibold text-gray-900">Detail Menu</span>
                    <button wire:click="closeProductModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                {{-- Product Image --}}
                <div class="aspect-square bg-gray-100 mx-4 mt-4 rounded-xl overflow-hidden">
                    @if($selectedProduct['image'])
                        <img src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-bowl-food text-6xl"></i>
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
                        <textarea wire:model="modalNotes" placeholder="Add notes to your order..." rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none resize-none"></textarea>
                    </div>
                    
                    {{-- Quantity --}}
                    <div class="flex items-center justify-center gap-4 mt-4 py-3 bg-gray-50 rounded-xl">
                        <button wire:click="decrementModalQty" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="text-xl font-bold w-12 text-center">{{ $modalQuantity }}</span>
                        <button wire:click="incrementModalQty" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    
                    {{-- Add to Cart --}}
                    <button wire:click="addToCart" class="w-full mt-4 py-4 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                        Add to Cart (Rp {{ number_format($selectedProduct['price'] * $modalQuantity, 0, ',', '.') }})
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
