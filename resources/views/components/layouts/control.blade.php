@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title }} - Setara Space POS</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('storage/logo.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        golden: {
                            400: '#FBBF24',
                            500: '#F9A825',
                        }
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
    
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50 min-h-screen">
    
    <div x-data="{ sidebarOpen: false }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen" class="relative">
        
        {{-- Overlay --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
             x-cloak></div>
        
        {{-- Sidebar Panel --}}
        <aside x-show="sidebarOpen"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed left-0 top-0 bottom-0 w-72 bg-white shadow-2xl z-50 flex flex-col"
               x-cloak>
            
            {{-- User Info --}}
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-space-600 to-space-800 flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->roles->first()->name ?? 'Staff' }}</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-red-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('control.dashboard') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.dashboard') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('control.pos') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.pos') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-cash-register w-5 text-center"></i>
                    <span>Point of Sales</span>
                </a>
                <a href="{{ route('control.activity') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.activity') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-list-alt w-5 text-center"></i>
                    <span>Activity</span>
                </a>
                <a href="{{ route('control.report') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.report') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-chart-bar w-5 text-center"></i>
                    <span>Report</span>
                </a>
                <a href="{{ route('control.inventory') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.inventory') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-box w-5 text-center"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('control.teams') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.teams') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Teams</span>
                </a>
                <a href="{{ route('control.settings') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.settings') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </nav>
            
            {{-- Logout --}}
            <div class="p-4 border-t border-gray-100">
                <form action="{{ route('control.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="min-h-screen">
            {{ $slot }}
        </main>
        
        {{-- Store sidebar state in window for child components --}}
        <template x-teleport="body">
            <div x-init="window.toggleSidebar = () => sidebarOpen = !sidebarOpen"></div>
        </template>
    </div>
    
    @livewireScripts
</body>
</html>
