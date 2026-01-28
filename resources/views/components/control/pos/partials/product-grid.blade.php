<div class="flex-1 flex flex-col overflow-hidden bg-gradient-to-br from-slate-50 to-blue-50/50">
            
    {{-- Category Tabs - Fixed size cards with horizontal scroll --}}
    <div class="px-4 pt-4 pb-2 flex-shrink-0">
        <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2 -mx-1 px-1">
            {{-- All Menu --}}
            <button wire:click="selectCategory('all')" 
                    class="flex flex-col items-center justify-center w-28 h-24 flex-shrink-0 rounded-2xl border transition-all duration-300 {{ !$selectedCategory ? 'bg-space-800/90 backdrop-blur-md text-white border-space-600 shadow-lg shadow-space-800/30' : 'bg-white/60 backdrop-blur-md text-gray-600 border-white/60 hover:bg-blue-50/50 hover:shadow-md' }}">
                <i class="fas fa-th-large text-2xl mb-2"></i>
                <span class="text-xs font-semibold">All Menu</span>
                <span class="text-[10px] {{ !$selectedCategory ? 'text-space-200' : 'text-gray-400' }}">{{ $products->count() }} items</span>
            </button>
            
            {{-- Categories --}}
            @foreach($categories as $category)
                <button wire:click="selectCategory({{ $category->id }})" 
                        class="flex flex-col items-center justify-center w-28 h-24 flex-shrink-0 rounded-2xl border transition-all duration-300 {{ $selectedCategory === $category->id ? 'bg-space-800/90 backdrop-blur-md text-white border-space-600 shadow-lg shadow-space-800/30' : 'bg-white/60 backdrop-blur-md text-gray-600 border-white/60 hover:bg-blue-50/50 hover:shadow-md' }}">
                    <i class="{{ $category->icon ?? 'fas fa-bowl-food' }} text-2xl mb-2"></i>
                    <span class="text-xs font-semibold truncate max-w-[90px]">{{ $category->name }}</span>
                    <span class="text-[10px] {{ $selectedCategory === $category->id ? 'text-space-200' : 'text-gray-400' }}">{{ $category->products_count }} items</span>
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
    <div class="flex-1 overflow-y-auto px-4 pb-24 sm:pb-4">
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

    {{-- Mobile Floating Cart Button --}}
    @if(count($cartItems) > 0)
        <div class="sm:hidden fixed bottom-4 left-4 right-4 z-40" 
                x-show="!showMobileCart"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-y-20 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-20 opacity-0">
            <button @click="showMobileCart = true" class="w-full bg-space-800 text-white p-4 rounded-xl shadow-xl flex items-center justify-between border border-space-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center font-bold text-lg backdrop-blur-sm">
                        {{ array_sum(array_column($cartItems, 'quantity')) }}
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-xs text-space-200">Total Payment</span>
                        <span class="font-bold text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 font-semibold bg-white/10 px-3 py-1.5 rounded-lg text-sm">
                    View Order <i class="fas fa-chevron-up"></i>
                </div>
            </button>
        </div>
    @endif
</div>
