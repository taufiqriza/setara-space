<x-frontend.layout title="Beranda">

    {{-- Hero Section --}}
    <section id="beranda" class="relative min-h-[90vh] lg:min-h-screen flex items-center pt-24 pb-12 lg:py-0 overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-cream-100 via-cream-50 to-space-50"></div>
        
        {{-- Decorative Elements (Reduced for mobile) --}}
        <div class="absolute top-20 right-10 w-48 h-48 lg:w-72 lg:h-72 bg-space-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-64 h-64 lg:w-96 lg:h-96 bg-golden-200/30 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 w-full">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-20 items-center">
                {{-- Content --}}
                <div class="text-center lg:text-left order-2 lg:order-1 relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 lg:px-4 lg:py-2 bg-space-100 rounded-full mb-6">
                        <span class="w-1.5 h-1.5 lg:w-2 lg:h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-space-700 text-xs lg:text-sm font-medium">Available on GoFood <i class="fas fa-motorcycle text-green-500 ml-1"></i></span>
                    </div>
                    
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-space-950 leading-tight mb-4 lg:mb-6">
                        Dimsum
                        <span class="block gradient-text">Homemade</span>
                        <span class="block text-2xl sm:text-4xl lg:text-5xl mt-2 font-normal text-space-600">Satu Semesta Seribu Rasa</span>
                    </h1>
                    
                    <p class="text-space-600 text-base lg:text-xl leading-relaxed mb-6 lg:mb-8 max-w-lg mx-auto lg:mx-0 px-4 lg:px-0">
                        Nikmati kelezatan dimsum homemade dengan cita rasa autentik. Dibuat fresh setiap hari di Yogyakarta!
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 justify-center lg:justify-start px-4 lg:px-0">
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="px-6 py-3 lg:px-8 lg:py-4 bg-gradient-to-r from-space-800 to-space-700 text-white font-semibold rounded-full hover:from-space-700 hover:to-space-600 hover:shadow-xl hover:shadow-space-800/30 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 text-sm lg:text-base">
                            <i class="fas fa-motorcycle"></i>
                            Order GoFood
                        </a>
                        <a href="#menu" class="px-6 py-3 lg:px-8 lg:py-4 bg-white text-space-800 font-semibold rounded-full border-2 border-space-200 hover:border-space-400 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 text-sm lg:text-base">
                            <i class="fas fa-utensils"></i>
                            Lihat Menu
                        </a>
                    </div>
                </div>
                
                {{-- Image --}}
                <div class="order-1 lg:order-2 relative flex justify-center lg:block">
                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 lg:w-[500px] lg:h-[500px]">
                        {{-- Decorative Circle --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-space-300 to-space-500 rounded-full animate-float"></div>
                        
                        {{-- Dimsum Image --}}
                        <div class="absolute inset-2 lg:inset-4 rounded-full overflow-hidden shadow-2xl shadow-space-900/20 border-4 border-white">
                            <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                        </div>
                        
                        {{-- Floating Badge 1 (Mobile Optimized) --}}
                        <div class="absolute -left-2 top-1/4 bg-white rounded-xl lg:rounded-2xl p-3 lg:p-4 shadow-lg shadow-space-200/50 animate-float z-20" style="animation-delay: 1s;">
                            <div class="flex items-center gap-2 lg:gap-3">
                                <div class="w-8 h-8 lg:w-12 lg:h-12 bg-golden-100 rounded-lg lg:rounded-xl flex items-center justify-center">
                                    <i class="fas fa-fire text-golden-600 text-sm lg:text-xl"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-space-800 text-xs lg:text-base">Fresh</div>
                                    <div class="text-space-500 text-[10px] lg:text-xs">Daily</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Menu Section --}}
    <section id="menu" class="py-12 lg:py-32 bg-white relative overflow-hidden">
        {{-- Decorative --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-space-100/50 rounded-full -mr-32 -mt-32"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative">
            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-10 lg:mb-16">
                <span class="inline-block px-3 py-1 bg-space-100 text-space-600 text-xs lg:text-sm font-medium rounded-full mb-3 lg:mb-4">Menu Terlaris</span>
                <h2 class="font-display text-2xl sm:text-3xl lg:text-5xl font-bold text-space-900 mb-4 lg:mb-6">
                    Signature <span class="gradient-text">Dimsum</span>
                </h2>
                <p class="text-space-600 text-sm lg:text-lg px-4">
                    Menu favorit yang paling banyak dicari dan dinikmati pelanggan setia kami.
                </p>
            </div>
            
            {{-- Dimsum Signature - Horizontal Scroll on Mobile --}}
            <div class="mb-12">
                <div class="flex items-center justify-between mb-4 lg:mb-8 px-2 lg:px-0">
                    <h3 class="font-display text-lg lg:text-2xl font-bold text-space-800 flex items-center gap-2 lg:gap-3">
                        <i class="fas fa-star text-golden-500"></i>
                        Signature Dimsum
                    </h3>
                </div>
                
                {{-- Grid Container --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-8">
                    @php
                        $colorMap = [
                            'golden' => ['bg' => 'from-golden-100 to-golden-200', 'icon' => 'text-golden-600'],
                            'amber' => ['bg' => 'from-amber-100 to-amber-200', 'icon' => 'text-amber-600'],
                            'red' => ['bg' => 'from-red-100 to-red-200', 'icon' => 'text-red-600'],
                            'orange' => ['bg' => 'from-orange-100 to-orange-200', 'icon' => 'text-orange-600'],
                            'space' => ['bg' => 'from-space-100 to-space-200', 'icon' => 'text-space-600'],
                            'yellow' => ['bg' => 'from-yellow-100 to-yellow-200', 'icon' => 'text-yellow-700'],
                            'blue' => ['bg' => 'from-blue-100 to-blue-200', 'icon' => 'text-blue-600'],
                        ];
                    @endphp
                    @foreach($favorites as $product)
                        @php
                            $colors = $colorMap[$product->category->color] ?? $colorMap['golden'];
                        @endphp
                        {{-- Compact Card Style --}}
                        <div class="group bg-cream-50 rounded-2xl lg:rounded-3xl p-3 lg:p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-1 lg:hover:-translate-y-2 border border-transparent hover:border-space-200">
                            <div class="relative">
                                <div class="w-full aspect-square bg-gradient-to-br {{ $colors['bg'] }} rounded-xl lg:rounded-2xl mb-3 lg:mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="{{ $product->category->icon ?? 'fas fa-bowl-food' }} {{ $colors['icon'] }} text-3xl lg:text-5xl"></i>
                                    @endif
                                </div>
                                @if($loop->iteration === 1)
                                    <span class="absolute top-2 right-2 lg:top-3 lg:right-3 px-1.5 py-0.5 lg:px-3 lg:py-1 bg-dimsum-pink text-white text-[8px] lg:text-xs font-semibold rounded-full shadow-lg">Best Seller</span>
                                @elseif($loop->iteration === 2)
                                    <span class="absolute top-2 right-2 lg:top-3 lg:right-3 px-1.5 py-0.5 lg:px-3 lg:py-1 bg-golden-500 text-white text-[8px] lg:text-xs font-semibold rounded-full shadow-lg">Popular</span>
                                @elseif($loop->iteration === 4)
                                    <span class="absolute top-2 right-2 lg:top-3 lg:right-3 px-1.5 py-0.5 lg:px-3 lg:py-1 bg-space-800 text-white text-[8px] lg:text-xs font-semibold rounded-full shadow-lg">New!</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                <h3 class="font-display text-sm lg:text-xl font-semibold text-space-900 line-clamp-1 leading-tight">{{ $product->name }}</h3>
                                <p class="text-[10px] lg:text-xs font-medium text-space-400">{{ $product->category->name }}</p>
                            </div>
                            <p class="text-space-500 text-[10px] lg:text-sm mb-2 lg:mb-4 line-clamp-2 h-7 lg:h-10 leading-snug">{{ $product->description }}</p>
                            <div class="flex items-center justify-between mt-auto">
                                <p class="text-sm lg:text-lg font-bold text-space-700">{{ $product->formatted_price }}</p>
                                <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-8 h-8 lg:w-auto lg:h-auto lg:px-4 lg:py-2 bg-space-100 text-space-700 hover:bg-space-800 hover:text-white rounded-lg lg:rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-plus text-xs lg:hidden"></i>
                                    <span class="hidden lg:inline font-medium text-sm">Order</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Other Menu --}}
            <div class="mb-12" x-data="{ showAll: false }">
                <div class="flex items-center justify-between mb-4 lg:mb-8 px-2 lg:px-0">
                    <h3 class="font-display text-lg lg:text-2xl font-bold text-space-800 flex items-center gap-2 lg:gap-3">
                        <i class="fas fa-utensils text-space-500"></i>
                        Menu Lainnya
                    </h3>
                </div>
                
                {{-- Responsive Grid --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-8">
                    @foreach($others as $product)
                        @php
                            $colors = $colorMap[$product->category->color] ?? $colorMap['space'];
                        @endphp
                        <div x-show="showAll || {{ $loop->index }} < 6" class="group {{ $product->category->name === 'Paket' ? 'bg-gradient-to-br from-space-50 to-golden-50 border border-space-200' : 'bg-cream-50' }} rounded-2xl lg:rounded-3xl p-3 lg:p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-1 lg:hover:-translate-y-2">
                            <div class="relative">
                                <div class="w-full aspect-square bg-gradient-to-br {{ $colors['bg'] }} rounded-xl lg:rounded-2xl mb-3 lg:mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="{{ $product->category->icon ?? 'fas fa-utensils' }} {{ $colors['icon'] }} text-3xl lg:text-5xl"></i>
                                    @endif
                                </div>
                                @if($product->category->name === 'Paket')
                                    <span class="absolute top-2 right-2 lg:top-3 lg:right-3 px-1.5 py-0.5 lg:px-3 lg:py-1 bg-gradient-to-r from-dimsum-pink to-golden-500 text-white text-[8px] lg:text-xs font-semibold rounded-full shadow-sm">HEMAT</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <h3 class="font-display text-sm lg:text-xl font-semibold text-space-900 line-clamp-1 leading-tight">{{ $product->name }}</h3>
                            </div>
                            
                            <p class="text-space-500 text-[10px] lg:text-sm mb-2 lg:mb-4 line-clamp-2 h-8 lg:h-10 leading-snug">{{ $product->description }}</p>
                            
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between lg:gap-4 mt-auto">
                                <p class="text-sm lg:text-lg font-bold text-space-700 mb-2 lg:mb-0">{{ $product->formatted_price }}</p>
                                <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-2 bg-white border border-space-200 text-space-700 hover:bg-space-800 hover:text-white hover:border-space-800 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-300 flex items-center justify-center gap-1.5 shadow-sm">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- View All / Load More --}}
                <div class="text-center mt-8 lg:mt-12" x-show="!showAll && {{ $others->count() }} > 6">
                    <button @click="showAll = true" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-white border border-space-200 text-space-600 font-semibold rounded-full hover:bg-space-50 hover:border-space-300 hover:text-space-800 transition-all duration-300 shadow-sm">
                        <span>Lihat Menu Lainnya</span>
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                </div>
                
                {{-- IG Link (only shown when all items are visible or if list is short) --}}
                <div class="text-center mt-6 lg:mt-8" x-show="showAll || {{ $others->count() }} <= 6">
                    <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="inline-flex items-center gap-2 text-sm text-dimsum-pink hover:text-dimsum-orange font-medium transition-colors">
                        <i class="fab fa-instagram"></i>
                        Cek update terbaru di Instagram
                    </a>
                </div>
            </div>
            
        </div>
    </section>

    {{-- Why Choose Us Section --}}
    <section class="py-20 lg:py-32 bg-gradient-to-br from-space-800 to-space-950 text-white relative overflow-hidden">
        {{-- Animated Stars Background --}}
        <div class="absolute inset-0">
            <div class="absolute w-2 h-2 bg-white rounded-full top-[10%] left-[15%] animate-twinkle"></div>
            <div class="absolute w-1 h-1 bg-golden-300 rounded-full top-[20%] left-[25%] animate-twinkle" style="animation-delay: 0.3s;"></div>
            <div class="absolute w-2 h-2 bg-white rounded-full top-[15%] right-[20%] animate-twinkle" style="animation-delay: 0.7s;"></div>
            <div class="absolute w-1 h-1 bg-golden-400 rounded-full top-[30%] right-[30%] animate-twinkle" style="animation-delay: 1s;"></div>
            <div class="absolute w-2 h-2 bg-white rounded-full bottom-[25%] left-[10%] animate-twinkle" style="animation-delay: 0.5s;"></div>
            <div class="absolute w-1 h-1 bg-dimsum-pink rounded-full bottom-[15%] left-[35%] animate-twinkle" style="animation-delay: 1.2s;"></div>
            <div class="absolute w-2 h-2 bg-white rounded-full bottom-[20%] right-[15%] animate-twinkle" style="animation-delay: 0.8s;"></div>
            <div class="absolute w-1 h-1 bg-golden-300 rounded-full top-[50%] right-[10%] animate-twinkle" style="animation-delay: 1.5s;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                {{-- Content --}}
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-space-700 to-space-600 text-space-100 text-sm font-medium rounded-full mb-6 shadow-lg">
                        <i class="fas fa-rocket text-golden-400"></i>
                        Kenapa Setara Space?
                    </span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">
                        Satu Semesta<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-golden-400 via-golden-300 to-dimsum-pink">Seribu Rasa</span>
                    </h2>
                    <p class="text-space-300 text-lg leading-relaxed mb-10">
                        Kami berkomitmen menghadirkan dimsum homemade dengan kualitas terbaik. Setiap produk dibuat dengan cinta dan bahan-bahan berkualitas.
                    </p>
                    
                    <div class="space-y-5 mb-10">
                        <div class="group flex items-start gap-4 p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-golden-400/30 transition-all duration-300">
                            <div class="w-14 h-14 bg-gradient-to-br from-golden-400 to-golden-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-golden-500/30 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-fire text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-1 text-white">Fresh Made Daily</h4>
                                <p class="text-space-300 text-sm">Dibuat segar setiap hari tanpa bahan pengawet.</p>
                            </div>
                        </div>
                        <div class="group flex items-start gap-4 p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-dimsum-pink/30 transition-all duration-300">
                            <div class="w-14 h-14 bg-gradient-to-br from-dimsum-pink to-dimsum-coral rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-dimsum-pink/30 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-heart text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-1 text-white">Homemade with Love</h4>
                                <p class="text-space-300 text-sm">Resep rumahan yang diwariskan turun-temurun.</p>
                            </div>
                        </div>
                        <div class="group flex items-start gap-4 p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-green-400/30 transition-all duration-300">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-leaf text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-1 text-white">Bahan Berkualitas</h4>
                                <p class="text-space-300 text-sm">Menggunakan bahan-bahan segar dan berkualitas.</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-golden-400 to-golden-500 text-space-950 font-bold rounded-full hover:from-golden-300 hover:to-golden-400 hover:shadow-xl hover:shadow-golden-500/30 hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-motorcycle"></i>
                        Order Sekarang
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                {{-- Enhanced Visual --}}
                <div class="relative flex items-center justify-center">
                    {{-- Outer Glow Ring --}}
                    <div class="absolute w-80 h-80 sm:w-[420px] sm:h-[420px] rounded-full border-2 border-space-500/30 animate-pulse"></div>
                    <div class="absolute w-72 h-72 sm:w-96 sm:h-96 rounded-full border border-space-400/20"></div>
                    
                    {{-- Main Circle --}}
                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 bg-gradient-to-br from-space-500 via-space-600 to-space-700 rounded-full flex items-center justify-center shadow-2xl shadow-space-950/50">
                        {{-- Inner Gradient --}}
                        <div class="absolute inset-4 bg-gradient-to-br from-space-600/50 to-space-800/50 rounded-full"></div>
                        
                        {{-- Center Content --}}
                        <div class="relative text-center z-10">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-cream-100 to-cream-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl overflow-hidden">
                                <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                            </div>
                            <p class="font-display text-xl sm:text-2xl font-bold text-white">Semesta Rasa</p>
                            <p class="text-space-300 text-sm mt-1">Premium Dimsum</p>
                        </div>
                        
                        {{-- Orbiting Elements --}}
                        <div class="absolute w-full h-full animate-[spin_20s_linear_infinite]">
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-10 h-10 bg-gradient-to-br from-golden-400 to-golden-600 rounded-full flex items-center justify-center shadow-lg shadow-golden-500/50">
                                <i class="fas fa-star text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="absolute w-full h-full animate-[spin_25s_linear_infinite_reverse]">
                            <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-8 h-8 bg-gradient-to-br from-dimsum-pink to-dimsum-coral rounded-full flex items-center justify-center shadow-lg shadow-dimsum-pink/50">
                                <i class="fas fa-heart text-white text-xs"></i>
                            </div>
                        </div>
                        <div class="absolute w-full h-full animate-[spin_30s_linear_infinite]">
                            <div class="absolute top-1/2 -right-3 -translate-y-1/2 w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg shadow-green-500/50">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Floating Decorative Cards --}}
                    <div class="absolute -top-4 -right-4 lg:top-0 lg:-right-8 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 animate-float shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-golden-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-award text-space-900"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-sm">Premium</div>
                                <div class="text-space-300 text-xs">Quality</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-4 -left-4 lg:-bottom-8 lg:left-0 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 animate-float shadow-xl" style="animation-delay: 1.5s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-motorcycle text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-sm">GoFood</div>
                                <div class="text-space-300 text-xs">Ready</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="tentang" class="py-20 lg:py-32 bg-cream-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                {{-- Image --}}
                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-space-300/30">
                        <div class="aspect-[4/5] bg-gradient-to-br from-space-300 to-space-500 flex items-center justify-center">
                            <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-3/4 h-auto object-contain">
                        </div>
                    </div>
                    
                    {{-- Experience Badge --}}
                    <div class="absolute -bottom-6 -right-6 lg:right-10 w-32 h-32 bg-gradient-to-br from-space-800 to-space-700 rounded-3xl flex items-center justify-center text-white shadow-xl">
                        <div class="text-center">
                            <i class="fas fa-globe text-4xl text-golden-400"></i>
                            <div class="text-sm text-space-200">Semesta</div>
                        </div>
                    </div>
                </div>
                
                {{-- Content --}}
                <div>
                    <span class="inline-block px-4 py-2 bg-space-100 text-space-600 text-sm font-medium rounded-full mb-4">Tentang Kami</span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-space-900 mb-6">
                        Setara Space
                        <span class="block text-space-600">Dimsum Homemade</span>
                    </h2>
                    <p class="text-space-600 text-lg leading-relaxed mb-6">
                        Setara Space hadir untuk membawa pengalaman menikmati dimsum homemade dengan kualitas premium. Kami percaya bahwa makanan yang dibuat dengan cinta akan terasa berbeda.
                    </p>
                    <p class="text-space-500 leading-relaxed mb-8">
                        Berlokasi di Condongcatur, Sleman, Yogyakarta, kami berkomitmen menghadirkan dimsum fresh setiap hari. "Satu Semesta Seribu Rasa" adalah janji kami untuk memberikan variasi rasa yang tidak pernah membosankan.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="p-6 bg-white rounded-2xl">
                            <div class="w-12 h-12 bg-golden-100 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-fire text-golden-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-space-900 mb-1">Fresh Daily</h4>
                            <p class="text-space-500 text-sm">Dibuat segar setiap hari</p>
                        </div>
                        <div class="p-6 bg-white rounded-2xl">
                            <div class="w-12 h-12 bg-space-100 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-motorcycle text-space-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-space-900 mb-1">GoFood Ready</h4>
                            <p class="text-space-500 text-sm">Order mudah via GoFood</p>
                        </div>
                    </div>
                    
                    <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="inline-flex items-center gap-2 text-space-600 font-semibold hover:text-space-800 transition">
                        Ikuti Instagram Kami
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Reviews Section --}}
    <section id="ulasan" class="py-20 lg:py-32 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-block px-4 py-2 bg-space-100 text-space-600 text-sm font-medium rounded-full mb-4">Testimoni</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-space-900 mb-6">
                    Apa Kata <span class="gradient-text">Mereka?</span>
                </h2>
                <p class="text-space-600 text-lg">
                    Kepuasan pelanggan adalah prioritas utama kami!
                </p>
            </div>
            
            {{-- Reviews Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Review 1 --}}
                <div class="bg-cream-50 rounded-3xl p-8 relative">
                    <div class="absolute top-6 right-6 text-space-200 text-6xl font-serif">"</div>
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star text-golden-500"></i>
                        @endfor
                    </div>
                    <p class="text-space-700 leading-relaxed mb-6 relative z-10">
                        "Dimsum-nya enak banget! Fresh dan rasanya homemade banget. Keju gorengnya juara, melting sempurna!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-space-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-space-600"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-space-900">Dinda Ayu</div>
                            <div class="text-space-500 text-sm">Yogyakarta</div>
                        </div>
                    </div>
                </div>
                
                {{-- Review 2 --}}
                <div class="bg-cream-50 rounded-3xl p-8 relative">
                    <div class="absolute top-6 right-6 text-space-200 text-6xl font-serif">"</div>
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star text-golden-500"></i>
                        @endfor
                    </div>
                    <p class="text-space-700 leading-relaxed mb-6 relative z-10">
                        "Dimsum mentai-nya asli nagih! Sausnya creamy banget. Pengiriman via GoFood juga cepat. Recommended!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-dimsum-pink/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-dimsum-pink"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-space-900">Rizki Pratama</div>
                            <div class="text-space-500 text-sm">Sleman</div>
                        </div>
                    </div>
                </div>
                
                {{-- Review 3 --}}
                <div class="bg-cream-50 rounded-3xl p-8 relative md:col-span-2 lg:col-span-1">
                    <div class="absolute top-6 right-6 text-space-200 text-6xl font-serif">"</div>
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star text-golden-500"></i>
                        @endfor
                    </div>
                    <p class="text-space-700 leading-relaxed mb-6 relative z-10">
                        "Wonton frozen-nya praktis banget buat stok di rumah. Tinggal kukus atau goreng, rasanya tetap enak!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-golden-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-golden-600"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-space-900">Mega Putri</div>
                            <div class="text-space-500 text-sm">Condongcatur</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Location Section --}}
    <section id="lokasi" class="py-20 lg:py-32 bg-gradient-to-br from-space-100 via-cream-100 to-golden-50 relative overflow-hidden">
        {{-- Decorative --}}
        <div class="absolute top-10 left-10 w-32 h-32 bg-space-200/50 rounded-full blur-2xl"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-golden-200/50 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Map/Location Info --}}
                <div>
                    <span class="inline-block px-4 py-2 bg-space-800 text-white text-sm font-medium rounded-full mb-4">Lokasi Kami</span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-space-900 mb-6">
                        Temukan Kami<br>
                        <span class="text-space-600">di Yogyakarta</span>
                    </h2>
                    <p class="text-space-600 text-lg mb-8">
                        Kunjungi kami atau order langsung via GoFood untuk pengalaman menikmati dimsum homemade terbaik!
                    </p>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-xl mb-6">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-space-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-space-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-space-900 mb-1">Alamat</h4>
                                <p class="text-space-600 text-sm">Jl. Wahid Hasyim, Dabag, Condongcatur, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</p>
                            </div>
                        </div>
                        <a href="https://maps.app.goo.gl/6wqNCWCKVqgNFNKJ8" target="_blank" class="w-full py-3 bg-space-800 text-white font-medium rounded-xl hover:bg-space-700 transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-directions"></i>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
                
                {{-- Order CTA --}}
                <div class="text-center lg:text-left">
                    <div class="bg-gradient-to-br from-space-800 to-space-950 rounded-3xl p-8 lg:p-12 text-white relative overflow-hidden">
                        {{-- Stars decoration --}}
                        <div class="absolute inset-0 stars-bg opacity-30"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-gradient-to-br from-golden-400 to-golden-500 rounded-full flex items-center justify-center mx-auto lg:mx-0 mb-6 shadow-xl">
                                <i class="fas fa-motorcycle text-space-950 text-3xl"></i>
                            </div>
                            <h3 class="font-display text-2xl lg:text-3xl font-bold mb-4">Order via GoFood</h3>
                            <p class="text-space-300 mb-8">
                                Pesan sekarang dan nikmati dimsum homemade favorit kamu langsung diantar ke rumah!
                            </p>
                            <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-green-500 hover:bg-green-400 text-white font-bold text-lg rounded-full transition-all duration-300 hover:shadow-xl hover:shadow-green-500/30 hover:-translate-y-1">
                                <i class="fas fa-motorcycle"></i>
                                Order Sekarang
                            </a>
                        </div>
                    </div>
                    
                    {{-- Trust Badges --}}
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 mt-8">
                        <div class="flex items-center gap-2 text-space-500">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm">Fresh Daily</span>
                        </div>
                        <div class="flex items-center gap-2 text-space-500">
                            <i class="fas fa-heart text-dimsum-pink"></i>
                            <span class="text-sm">Homemade</span>
                        </div>
                        <div class="flex items-center gap-2 text-space-500">
                            <i class="fas fa-motorcycle text-space-600"></i>
                            <span class="text-sm">GoFood Ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-frontend.layout>
