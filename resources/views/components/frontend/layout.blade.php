<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $title ?? 'Beranda' }} - Setara Space | Dimsum Homemade</title>
    <meta name="description" content="Setara Space - Dimsum Homemade Kekinian. Satu Semesta Seribu Rasa. Order via GoFood!">
    
    <link rel="icon" type="image/jpeg" href="{{ asset('storage/logo.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        space: {
                            50: '#eef1ff',
                            100: '#e0e5ff',
                            200: '#c7ceff',
                            300: '#a5acff',
                            400: '#8180ff',
                            500: '#6b5cfa',
                            600: '#5b3def',
                            700: '#4d30db',
                            800: '#3B4CCA',
                            900: '#2d2a8c',
                            950: '#1A1A2E'
                        },
                        cream: {
                            50: '#FFFDF7',
                            100: '#FFF8E7',
                            200: '#FFF3D6',
                            300: '#FFECC0',
                            400: '#FFE4A8',
                            500: '#FFDB8A'
                        },
                        golden: {
                            50: '#FFFBEB',
                            100: '#FEF3C7',
                            200: '#FDE68A',
                            300: '#FCD34D',
                            400: '#FBBF24',
                            500: '#F9A825',
                            600: '#D97706',
                            700: '#B45309'
                        },
                        dimsum: {
                            pink: '#E91E63',
                            orange: '#FF6B35',
                            coral: '#FF8A5B'
                        }
                    },
                    fontFamily: {
                        'display': ['Outfit', 'system-ui', 'sans-serif'],
                        'serif': ['Playfair Display', 'Georgia', 'serif']
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .glass-dark {
            background: rgba(59, 76, 202, 0.95);
            backdrop-filter: blur(20px);
        }
        .glass-space {
            background: rgba(26, 26, 46, 0.85);
            backdrop-filter: blur(20px);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FFF8E7; }
        ::-webkit-scrollbar-thumb { background: #3B4CCA; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #2d2a8c; }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        @keyframes twinkle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        .animate-twinkle { animation: twinkle 2s ease-in-out infinite; }
        
        @keyframes orbit {
            from { transform: rotate(0deg) translateX(10px) rotate(0deg); }
            to { transform: rotate(360deg) translateX(10px) rotate(-360deg); }
        }
        .animate-orbit { animation: orbit 8s linear infinite; }

        @keyframes steam {
            0% { transform: translateY(0) scale(1); opacity: 0.8; }
            50% { transform: translateY(-15px) scale(1.1); opacity: 0.4; }
            100% { transform: translateY(-30px) scale(0.9); opacity: 0; }
        }
        .animate-steam { animation: steam 2s ease-out infinite; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease forwards; }
        
        /* Stars Background */
        .stars-bg {
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #FFD700, transparent),
                radial-gradient(2px 2px at 40px 70px, #FFF, transparent),
                radial-gradient(1px 1px at 90px 40px, #FFD700, transparent),
                radial-gradient(2px 2px at 160px 20px, #FFF, transparent),
                radial-gradient(1px 1px at 200px 60px, #FFD700, transparent),
                radial-gradient(2px 2px at 250px 80px, #FFF, transparent);
            background-repeat: repeat;
            background-size: 300px 100px;
        }
        
        /* Mobile Bottom Nav Padding */
        .main-content { padding-bottom: 5rem; }
        @media (min-width: 1024px) { .main-content { padding-bottom: 0; } }
        
        /* Safe area for iOS */
        .safe-area-bottom { padding-bottom: env(safe-area-inset-bottom); }
        
        [x-cloak] { display: none !important; }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #3B4CCA 0%, #E91E63 50%, #F9A825 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-cream-100 text-space-950 antialiased">

    {{-- Desktop Header --}}
    <header class="hidden lg:block fixed top-0 left-0 right-0 z-50 transition-all duration-500" 
        x-data="{ scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 50"
        :class="scrolled ? 'glass shadow-xl shadow-space-800/10 py-2' : 'bg-transparent py-4'">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-space-800/30 group-hover:shadow-xl group-hover:shadow-space-800/40 transition-all duration-300 group-hover:scale-105 overflow-hidden">
                        <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="font-display text-2xl font-bold text-space-800 block leading-tight">Setara Space</span>
                        <span class="text-xs text-space-600 font-medium tracking-wider"><i class="fas fa-globe text-space-400"></i> Semesta Rasa</span>
                    </div>
                </a>

                {{-- Nav --}}
                <nav class="flex items-center bg-white/60 backdrop-blur-md rounded-full px-2 py-2 shadow-lg shadow-space-100/50 border border-white/50">
                    <a href="#beranda" class="group flex items-center gap-2 px-5 py-2.5 rounded-full text-space-700 hover:bg-space-800 hover:text-white font-medium transition-all duration-300">
                        <i class="fas fa-home text-sm opacity-70 group-hover:opacity-100"></i>
                        <span>Beranda</span>
                    </a>
                    <a href="#menu" class="group flex items-center gap-2 px-5 py-2.5 rounded-full text-space-700 hover:bg-space-800 hover:text-white font-medium transition-all duration-300">
                        <i class="fas fa-utensils text-sm opacity-70 group-hover:opacity-100"></i>
                        <span>Menu</span>
                    </a>
                    <a href="#tentang" class="group flex items-center gap-2 px-5 py-2.5 rounded-full text-space-700 hover:bg-space-800 hover:text-white font-medium transition-all duration-300">
                        <i class="fas fa-heart text-sm opacity-70 group-hover:opacity-100"></i>
                        <span>Tentang</span>
                    </a>
                    <a href="#ulasan" class="group flex items-center gap-2 px-5 py-2.5 rounded-full text-space-700 hover:bg-space-800 hover:text-white font-medium transition-all duration-300">
                        <i class="fas fa-star text-sm opacity-70 group-hover:opacity-100"></i>
                        <span>Ulasan</span>
                    </a>
                    <a href="#lokasi" class="group flex items-center gap-2 px-5 py-2.5 rounded-full text-space-700 hover:bg-space-800 hover:text-white font-medium transition-all duration-300">
                        <i class="fas fa-map-marker-alt text-sm opacity-70 group-hover:opacity-100"></i>
                        <span>Lokasi</span>
                    </a>
                </nav>

                {{-- CTA Buttons --}}
                <div class="flex items-center gap-3">
                    <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="w-12 h-12 bg-gradient-to-br from-dimsum-pink to-golden-500 hover:from-dimsum-pink hover:to-dimsum-orange rounded-xl flex items-center justify-center text-white transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="group px-6 py-3 bg-gradient-to-r from-space-800 to-space-700 text-white font-semibold rounded-xl hover:from-space-700 hover:to-space-600 hover:shadow-xl hover:shadow-space-800/40 transition-all duration-300 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-motorcycle group-hover:animate-bounce"></i>
                        <span>Order GoFood</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Header --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-50 glass shadow-lg">
        <div class="flex items-center justify-between h-16 px-4">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center overflow-hidden shadow">
                    <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="font-display text-lg font-bold text-space-800 block leading-tight">Setara Space</span>
                    <span class="text-xs text-space-500">Semesta Rasa</span>
                </div>
            </a>
            <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="px-4 py-2 bg-gradient-to-r from-space-800 to-space-700 rounded-full flex items-center gap-2 text-white text-sm font-semibold shadow-lg">
                <i class="fas fa-motorcycle"></i>
                <span>GoFood</span>
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="main-content">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-space-950 text-white pt-12 lg:pt-16 pb-24 lg:pb-8 stars-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            {{-- Mobile Footer - Compact --}}
            <div class="lg:hidden">
                {{-- Brand & Social (Mobile) --}}
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                        </div>
                        <div class="text-left">
                            <span class="font-display text-xl font-bold block">Setara Space</span>
                            <span class="text-space-400 text-xs"><i class="fas fa-globe text-golden-400"></i> Semesta Rasa</span>
                        </div>
                    </div>
                    <p class="text-space-400 text-sm mb-4">Dimsum Homemade Kekinian • Yogyakarta</p>
                    
                    {{-- Social Icons --}}
                    <div class="flex justify-center gap-3">
                        <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="w-11 h-11 bg-gradient-to-br from-dimsum-pink to-golden-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fab fa-instagram text-white text-lg"></i>
                        </a>
                        <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-11 h-11 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-motorcycle text-white text-lg"></i>
                        </a>
                        <a href="https://maps.app.goo.gl/6wqNCWCKVqgNFNKJ8" target="_blank" class="w-11 h-11 bg-space-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Info Cards (Mobile) --}}
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <a href="https://maps.app.goo.gl/6wqNCWCKVqgNFNKJ8" target="_blank" class="bg-space-900/50 rounded-xl p-4 text-center hover:bg-space-800 transition">
                        <i class="fas fa-map-marker-alt text-golden-400 text-xl mb-2"></i>
                        <p class="text-white text-sm font-medium">Lokasi</p>
                        <p class="text-space-400 text-xs">Condongcatur, Sleman</p>
                    </a>
                    <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="bg-space-900/50 rounded-xl p-4 text-center hover:bg-space-800 transition">
                        <i class="fas fa-motorcycle text-green-400 text-xl mb-2"></i>
                        <p class="text-white text-sm font-medium">Order</p>
                        <p class="text-space-400 text-xs">via GoFood</p>
                    </a>
                </div>

                {{-- Copyright (Mobile) --}}
                <div class="text-center pt-4 border-t border-space-800">
                    <p class="text-space-500 text-xs">© {{ date('Y') }} Setara Space - Semesta Rasa</p>
                </div>
            </div>

            {{-- Desktop Footer - Full --}}
            <div class="hidden lg:block">
                <div class="grid grid-cols-4 gap-10 mb-12">
                    {{-- Brand --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="font-display text-2xl font-bold block">Setara Space</span>
                                <span class="text-space-400 text-sm"><i class="fas fa-globe text-golden-400"></i> Semesta Rasa</span>
                            </div>
                        </div>
                        <p class="text-space-300 text-sm leading-relaxed mb-6">
                            Dimsum Homemade Kekinian dengan satu semesta seribu rasa. Order sekarang via GoFood!
                        </p>
                        <div class="flex gap-3">
                            <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="w-10 h-10 bg-gradient-to-br from-dimsum-pink to-golden-500 hover:from-dimsum-orange hover:to-golden-400 rounded-full flex items-center justify-center transition shadow-lg">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                            <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="w-10 h-10 bg-green-500 hover:bg-green-400 rounded-full flex items-center justify-center transition">
                                <i class="fas fa-motorcycle text-white"></i>
                            </a>
                            <a href="https://maps.app.goo.gl/6wqNCWCKVqgNFNKJ8" target="_blank" class="w-10 h-10 bg-space-700 hover:bg-space-600 rounded-full flex items-center justify-center transition">
                                <i class="fas fa-map-marker-alt"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div>
                        <h4 class="font-display text-lg font-semibold mb-6">Navigasi</h4>
                        <ul class="space-y-3">
                            <li><a href="#beranda" class="text-space-300 hover:text-white transition">Beranda</a></li>
                            <li><a href="#menu" class="text-space-300 hover:text-white transition">Menu</a></li>
                            <li><a href="#tentang" class="text-space-300 hover:text-white transition">Tentang Kami</a></li>
                            <li><a href="#ulasan" class="text-space-300 hover:text-white transition">Ulasan</a></li>
                            <li><a href="#lokasi" class="text-space-300 hover:text-white transition">Lokasi</a></li>
                        </ul>
                    </div>

                    {{-- Contact --}}
                    <div>
                        <h4 class="font-display text-lg font-semibold mb-6">Kontak</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt text-golden-500 mt-1"></i>
                                <a href="https://maps.app.goo.gl/6wqNCWCKVqgNFNKJ8" target="_blank" class="text-space-300 text-sm hover:text-white transition">Jl. Wahid Hasyim, Dabag, Condongcatur,<br>Depok, Sleman, Yogyakarta 55281</a>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fab fa-instagram text-dimsum-pink"></i>
                                <a href="https://www.instagram.com/setaraspace.id" target="_blank" class="text-space-300 text-sm hover:text-white transition">@setaraspace.id</a>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fas fa-motorcycle text-green-400"></i>
                                <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="text-space-300 text-sm hover:text-white transition">Order via GoFood</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Order Info --}}
                    <div>
                        <h4 class="font-display text-lg font-semibold mb-6">Order Sekarang</h4>
                        <div class="bg-space-800 rounded-2xl p-4 mb-4">
                            <div class="flex items-center gap-2 text-green-400 mb-2">
                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="font-semibold">Available on GoFood</span>
                            </div>
                            <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-400 rounded-full text-white font-semibold text-sm transition">
                                <i class="fas fa-motorcycle"></i>
                                Order Now
                            </a>
                        </div>
                        <p class="text-space-400 text-sm italic"><i class="fas fa-globe text-golden-400"></i> Satu Semesta Seribu Rasa</p>
                    </div>
                </div>

                {{-- Bottom --}}
                <div class="border-t border-space-800 pt-8">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
                        <p class="text-space-400 text-sm">© {{ date('Y') }} Setara Space - Dimsum Homemade. Semesta Rasa.</p>
                        <div class="flex gap-6 text-sm">
                            <a href="#" class="text-space-400 hover:text-white transition">Kebijakan Privasi</a>
                            <a href="#" class="text-space-400 hover:text-white transition">Syarat & Ketentuan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Mobile Bottom Navigation --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-50 safe-area-bottom">
        {{-- Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-t from-space-950 via-space-900 to-space-800/95 backdrop-blur-xl"></div>
        {{-- Top Glow Line --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-golden-400/50 to-transparent"></div>
        
        <div class="relative flex items-center justify-around h-18 pt-2 pb-3">
            <a href="#beranda" class="group flex flex-col items-center gap-1 px-3 py-1">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/5 group-hover:bg-white/15 transition-all duration-300">
                    <i class="fas fa-home text-lg text-space-300 group-hover:text-white transition-colors"></i>
                </div>
                <span class="text-[10px] text-space-400 group-hover:text-white font-medium transition-colors">Beranda</span>
            </a>
            <a href="#menu" class="group flex flex-col items-center gap-1 px-3 py-1">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/5 group-hover:bg-white/15 transition-all duration-300">
                    <i class="fas fa-utensils text-lg text-space-300 group-hover:text-white transition-colors"></i>
                </div>
                <span class="text-[10px] text-space-400 group-hover:text-white font-medium transition-colors">Menu</span>
            </a>
            <a href="https://gofood.link/a/RGXVKRw" target="_blank" class="group flex flex-col items-center -mt-5">
                <div class="relative">
                    {{-- Glow Effect --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-golden-400 to-green-500 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    {{-- Button --}}
                    <div class="relative w-16 h-16 bg-gradient-to-br from-golden-400 via-golden-500 to-green-500 rounded-full flex items-center justify-center shadow-xl shadow-golden-500/30 border-4 border-space-950 group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-motorcycle text-space-950 text-xl"></i>
                    </div>
                </div>
                <span class="text-[10px] text-golden-400 font-bold mt-1">Order</span>
            </a>
            <a href="#ulasan" class="group flex flex-col items-center gap-1 px-3 py-1">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/5 group-hover:bg-white/15 transition-all duration-300">
                    <i class="fas fa-star text-lg text-space-300 group-hover:text-golden-400 transition-colors"></i>
                </div>
                <span class="text-[10px] text-space-400 group-hover:text-white font-medium transition-colors">Ulasan</span>
            </a>
            <a href="#lokasi" class="group flex flex-col items-center gap-1 px-3 py-1">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/5 group-hover:bg-white/15 transition-all duration-300">
                    <i class="fas fa-map-marker-alt text-lg text-space-300 group-hover:text-white transition-colors"></i>
                </div>
                <span class="text-[10px] text-space-400 group-hover:text-white font-medium transition-colors">Lokasi</span>
            </a>
        </div>
    </nav>

    {{-- WhatsApp/Instagram Floating Button --}}
    <div x-data="{ showGreeting: false, hasShown: false }" 
         x-init="setTimeout(() => { if(!hasShown) { showGreeting = true; hasShown = true; } }, 3000)"
         class="fixed z-50 lg:bottom-8 lg:right-8 bottom-24 right-4">
        
        {{-- Greeting Modal --}}
        <div x-show="showGreeting" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="absolute bottom-full right-0 mb-4 w-72 bg-white rounded-2xl shadow-2xl shadow-space-300/30 p-5 border border-space-100"
             x-cloak>
            <button @click="showGreeting = false" class="absolute top-3 right-3 w-6 h-6 text-space-400 hover:text-space-600 transition">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="font-semibold text-space-800">Setara Space</p>
                    <p class="text-xs text-space-500">Ada promo menarik nih! <i class="fas fa-gift text-golden-400"></i></p>
                </div>
            </div>
            <div class="bg-space-50 rounded-xl p-3 mb-4">
                <p class="text-sm text-space-700">Halo! 👋 Yuk order dimsum favorit kamu via GoFood atau cek Instagram kami untuk promo terbaru!</p>
            </div>
            <div class="flex gap-2">
                <a href="https://gofood.link/a/RGXVKRw" target="_blank" 
                   class="flex-1 flex items-center justify-center gap-2 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition-all duration-300">
                    <i class="fas fa-motorcycle"></i>
                    GoFood
                </a>
                <a href="https://www.instagram.com/setaraspace.id" target="_blank" 
                   class="flex-1 flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-dimsum-pink to-golden-500 text-white font-semibold rounded-xl transition-all duration-300">
                    <i class="fab fa-instagram"></i>
                    IG
                </a>
            </div>
        </div>
        
        {{-- Floating Button --}}
        <button @click="showGreeting = !showGreeting" 
                class="group w-16 h-16 bg-gradient-to-br from-space-700 to-space-800 hover:from-space-600 hover:to-space-700 rounded-full flex items-center justify-center shadow-xl shadow-space-800/40 hover:shadow-2xl hover:shadow-space-800/50 transition-all duration-300 hover:scale-110">
            <i class="fas fa-comment-dots text-white text-2xl group-hover:scale-110 transition-transform"></i>
        </button>
        
        {{-- Pulse Animation --}}
        <span class="absolute top-0 right-0 w-4 h-4">
            <span class="absolute inline-flex h-full w-full rounded-full bg-golden-400 opacity-75 animate-ping"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-golden-500"></span>
        </span>
    </div>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
