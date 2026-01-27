<x-frontend.layout title="Beranda">

    {{-- Hero Section --}}
    <section id="beranda" class="relative min-h-screen flex items-center pt-16 lg:pt-0 overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-cream-100 via-cream-50 to-space-50"></div>
        
        {{-- Decorative Elements --}}
        <div class="absolute top-20 right-10 w-72 h-72 bg-space-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-golden-200/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-golden-400 rounded-full animate-twinkle"></div>
        <div class="absolute top-1/3 right-1/3 w-3 h-3 bg-dimsum-pink rounded-full animate-twinkle" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-1/3 right-1/4 w-2 h-2 bg-space-400 rounded-full animate-twinkle" style="animation-delay: 1s;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-0">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                {{-- Content --}}
                <div class="text-center lg:text-left order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-space-100 rounded-full mb-6">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-space-700 text-sm font-medium">Available on GoFood <i class="fas fa-motorcycle text-green-500"></i></span>
                    </div>
                    
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-space-950 leading-tight mb-6">
                        Dimsum
                        <span class="block gradient-text">Homemade</span>
                        <span class="block text-3xl sm:text-4xl lg:text-5xl mt-2 font-normal text-space-600">Satu Semesta Seribu Rasa</span>
                    </h1>
                    
                    <p class="text-space-600 text-lg lg:text-xl leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">
                        Nikmati kelezatan dimsum homemade dengan cita rasa autentik. Dibuat fresh setiap hari di Yogyakarta!
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="px-8 py-4 bg-gradient-to-r from-space-800 to-space-700 text-white font-semibold rounded-full hover:from-space-700 hover:to-space-600 hover:shadow-xl hover:shadow-space-800/30 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i>
                            Order via GoFood
                        </a>
                        <a href="#menu" class="px-8 py-4 bg-white text-space-800 font-semibold rounded-full border-2 border-space-200 hover:border-space-400 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-utensils"></i>
                            Lihat Menu
                        </a>
                    </div>
                    
                    {{-- Stats --}}
                    <div class="flex items-center justify-center lg:justify-start gap-8 mt-12 pt-8 border-t border-space-200">
                        <div class="text-center">
                            <div class="font-display text-3xl font-bold text-space-800">500+</div>
                            <div class="text-space-500 text-sm">Followers</div>
                        </div>
                        <div class="w-px h-12 bg-space-200"></div>
                        <div class="text-center">
                            <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="flex items-center gap-1 text-dimsum-pink hover:text-dimsum-orange">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                            <div class="text-space-500 text-sm">@setaraspace.id</div>
                        </div>
                        <div class="w-px h-12 bg-space-200"></div>
                        <div class="text-center">
                            <a href="https://maps.app.goo.gl/6wqNCWCKVqgNFNKJ8" target="_blank" class="text-space-600 hover:text-space-800">
                                <i class="fas fa-map-marker-alt text-2xl"></i>
                            </a>
                            <div class="text-space-500 text-sm">Yogyakarta</div>
                        </div>
                    </div>
                </div>
                
                {{-- Image --}}
                <div class="order-1 lg:order-2 relative">
                    <div class="relative">
                        {{-- Main Image Container --}}
                        <div class="relative w-72 h-72 sm:w-96 sm:h-96 lg:w-[500px] lg:h-[500px] mx-auto">
                            {{-- Decorative Circle --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-space-300 to-space-500 rounded-full animate-float"></div>
                            
                            {{-- Dimsum Image --}}
                            <div class="absolute inset-4 rounded-full overflow-hidden shadow-inner">
                                <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                            </div>
                            
                            {{-- Steam Animation --}}
                            <div class="absolute top-8 left-1/2 -translate-x-1/2">
                                <div class="w-2 h-8 bg-white/60 rounded-full animate-steam"></div>
                                <div class="w-2 h-8 bg-white/60 rounded-full animate-steam absolute left-4" style="animation-delay: 0.5s;"></div>
                                <div class="w-2 h-8 bg-white/60 rounded-full animate-steam absolute -left-4" style="animation-delay: 1s;"></div>
                            </div>
                            
                            {{-- Floating Badge 1 --}}
                            <div class="absolute -left-4 top-1/4 bg-white rounded-2xl p-4 shadow-xl shadow-space-200/50 animate-float" style="animation-delay: 1s;">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-golden-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-fire text-golden-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-space-800">Fresh</div>
                                        <div class="text-space-500 text-xs">Made Daily</div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Floating Badge 2 --}}
                            <div class="absolute -right-4 bottom-1/4 bg-white rounded-2xl p-4 shadow-xl shadow-space-200/50 animate-float" style="animation-delay: 2s;">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-dimsum-pink/20 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-heart text-dimsum-pink text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-space-800">Homemade</div>
                                        <div class="text-space-500 text-xs">With Love</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Planet Decoration --}}
                            <div class="absolute -top-4 right-1/4 w-8 h-8 bg-golden-400 rounded-full shadow-lg animate-orbit">
                                <div class="absolute inset-0 bg-gradient-to-br from-golden-300 to-golden-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 hidden lg:flex flex-col items-center gap-2 text-space-400">
            <span class="text-sm">Scroll</span>
            <div class="w-6 h-10 border-2 border-space-300 rounded-full flex justify-center pt-2">
                <div class="w-1.5 h-3 bg-space-400 rounded-full animate-bounce"></div>
            </div>
        </div>
    </section>

    {{-- Featured Menu Section --}}
    <section id="menu" class="py-20 lg:py-32 bg-white relative overflow-hidden">
        {{-- Decorative --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-space-100/50 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-golden-100/50 rounded-full -ml-24 -mb-24"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative">
            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-block px-4 py-2 bg-space-100 text-space-600 text-sm font-medium rounded-full mb-4">Menu Andalan</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-space-900 mb-6">
                    Dimsum <span class="gradient-text">Favorit</span> Kami
                </h2>
                <p class="text-space-600 text-lg">
                    Pilihan dimsum homemade dengan kualitas premium dan rasa yang bikin ketagihan!
                </p>
            </div>
            
            {{-- Dimsum Signature --}}
            <div class="mb-12">
                <h3 class="font-display text-2xl font-bold text-space-800 mb-8 flex items-center gap-3">
                    <i class="fas fa-star text-golden-500"></i>
                    Signature Dimsum
                </h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                    {{-- Dimsum Ayam Original --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative">
                            <div class="w-full aspect-square bg-gradient-to-br from-golden-100 to-golden-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <i class="fas fa-drumstick-bite text-golden-600 text-5xl"></i>
                            </div>
                            <span class="absolute top-3 right-3 px-3 py-1 bg-dimsum-pink text-white text-xs font-semibold rounded-full">Best Seller</span>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Dimsum Ayam Original</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Dimsum ayam dengan kulit tipis lembut, isian daging ayam juicy.</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>
                    
                    {{-- Dimsum Keju Goreng --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative">
                            <div class="w-full aspect-square bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <i class="fas fa-cheese text-amber-600 text-5xl"></i>
                            </div>
                            <span class="absolute top-3 right-3 px-3 py-1 bg-golden-500 text-white text-xs font-semibold rounded-full">Popular</span>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Dimsum Keju Goreng</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Dimsum crispy dengan lelehan keju yang bikin nagih!</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>
                    
                    {{-- Dimsum Pedas --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="w-full aspect-square bg-gradient-to-br from-red-100 to-red-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <i class="fas fa-pepper-hot text-red-600 text-5xl"></i>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Dimsum Pedas</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Pedasnya nendang! Cocok buat kamu pencinta makanan pedas.</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>
                    
                    {{-- Dimsum Mentai --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative">
                            <div class="w-full aspect-square bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <i class="fas fa-fire-flame-curved text-orange-600 text-5xl"></i>
                            </div>
                            <span class="absolute top-3 right-3 px-3 py-1 bg-space-800 text-white text-xs font-semibold rounded-full">New!</span>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Dimsum Mentai</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Saus mentai creamy yang meleleh, rasanya bikin ketagihan!</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>
                </div>
            </div>

            {{-- Other Menu --}}
            <div class="mb-12">
                <h3 class="font-display text-2xl font-bold text-space-800 mb-8 flex items-center gap-3">
                    <i class="fas fa-utensils text-space-500"></i>
                    Menu Lainnya
                </h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                    {{-- Wonton Frozen --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="w-full aspect-square bg-gradient-to-br from-space-100 to-space-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <i class="fas fa-snowflake text-space-600 text-5xl"></i>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Wonton Frozen</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Wonton siap masak untuk stok di rumah. Praktis!</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>
                    
                    {{-- Mie Dimsum --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="w-full aspect-square bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <i class="fas fa-bowl-rice text-yellow-700 text-5xl"></i>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Mie Dimsum</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Mie kuah dengan topping dimsum dan chili oil.</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>

                    {{-- Lumpia --}}
                    <div class="group bg-cream-50 rounded-3xl p-6 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="w-full aspect-square bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <i class="fas fa-hotdog text-amber-700 text-5xl"></i>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Lumpia Goreng</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Lumpia crispy dengan isian sayur dan daging.</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-space-100 text-space-700 font-medium rounded-xl hover:bg-space-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>

                    {{-- Paket Komplit --}}
                    <div class="group bg-gradient-to-br from-space-50 to-golden-50 rounded-3xl p-6 border-2 border-space-200 hover:border-space-400 hover:shadow-xl hover:shadow-space-200/50 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative">
                            <div class="w-full aspect-square bg-gradient-to-br from-space-200 to-space-300 rounded-2xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <i class="fas fa-box-open text-space-600 text-5xl"></i>
                            </div>
                            <span class="absolute top-3 right-3 px-3 py-1 bg-gradient-to-r from-dimsum-pink to-golden-500 text-white text-xs font-semibold rounded-full">HEMAT!</span>
                        </div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-display text-xl font-semibold text-space-900">Paket Komplit</h3>
                        </div>
                        <p class="text-space-500 text-sm mb-4">Paket lengkap berbagai varian dimsum favorit!</p>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-full py-3 bg-gradient-to-r from-space-800 to-space-700 text-white font-medium rounded-xl hover:from-space-700 hover:to-space-600 transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-motorcycle"></i> Order
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- View All --}}
            <div class="text-center mt-12">
                <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-dimsum-pink to-golden-500 text-white font-semibold rounded-full hover:from-dimsum-orange hover:to-golden-400 hover:shadow-xl transition-all duration-300">
                    <i class="fab fa-instagram"></i>
                    Lihat Menu Lengkap di Instagram
                </a>
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
