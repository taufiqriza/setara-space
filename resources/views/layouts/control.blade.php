<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Dashboard' }} - Setara Space POS</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('storage/logo.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        /* Hide Alpine elements until initialized */
        [x-cloak] { display: none !important; }
        
        body { font-family: 'Outfit', sans-serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Hide scrollbar but keep functionality */
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        
        /* Page transition loading animation */
        .page-loading {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e5ff 100%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        
        .page-loading .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid #e0e5ff;
            border-top-color: #3B4CCA;
            border-radius: 50%;
            animation: spin 0.8s ease-in-out infinite;
        }
        
        .page-loading .dots {
            display: flex;
            gap: 6px;
        }
        
        .page-loading .dots span {
            width: 10px;
            height: 10px;
            background: #3B4CCA;
            border-radius: 50%;
            animation: bounce 0.6s ease-in-out infinite;
        }
        
        .page-loading .dots span:nth-child(2) { animation-delay: 0.1s; }
        .page-loading .dots span:nth-child(3) { animation-delay: 0.2s; }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-8px); opacity: 0.6; }
        }
        
        /* Progress bar at top */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #3B4CCA, #6b5cfa, #8180ff);
            z-index: 10000;
            animation: progress 1s ease-out forwards;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        /* Sidebar - Smooth slide animation */
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .sidebar-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        
        .sidebar-panel {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-panel.open {
            transform: translateX(0);
        }
    </style>
    
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50 min-h-screen">
    
    {{-- Page Loading Indicator (Livewire Navigate) --}}
    <div wire:loading.delay.long class="page-loading">
        <div class="spinner"></div>
        <p class="text-gray-500 text-sm font-medium">Loading...</p>
    </div>
    
    {{-- Progress Bar --}}
    <div wire:loading.delay class="progress-bar"></div>
    
    {{-- Sidebar Overlay --}}
    <div id="sidebarOverlay" 
         class="sidebar-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity duration-300"
         onclick="closeSidebar()"></div>
    
    {{-- Sidebar Panel --}}
    <aside id="sidebarPanel" 
           class="sidebar-panel fixed left-0 top-0 bottom-0 w-72 bg-white shadow-2xl z-50 flex flex-col">
        
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
                <button onclick="closeSidebar()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('control.pos') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.pos') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               onclick="closeSidebar()">
                <i class="fas fa-cash-register w-5 text-center"></i>
                <span>Point of Sales</span>
            </a>
            <a href="{{ route('control.activity') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.activity') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               onclick="closeSidebar()">
                <i class="fas fa-list-alt w-5 text-center"></i>
                <span>Activity</span>
            </a>
            <a href="{{ route('control.report') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.report') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               onclick="closeSidebar()">
                <i class="fas fa-chart-bar w-5 text-center"></i>
                <span>Report</span>
            </a>
            <a href="{{ route('control.inventory') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.inventory') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               onclick="closeSidebar()">
                <i class="fas fa-box w-5 text-center"></i>
                <span>Products</span>
            </a>
            <a href="{{ route('control.teams') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.teams') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               onclick="closeSidebar()">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Teams</span>
            </a>
            <a href="{{ route('control.settings') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.settings') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               onclick="closeSidebar()">
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
    
    {{-- Sidebar Toggle Script --}}
    <script>
        function openSidebar() {
            document.getElementById('sidebarOverlay').classList.add('open');
            document.getElementById('sidebarPanel').classList.add('open');
        }
        
        function closeSidebar() {
            document.getElementById('sidebarOverlay').classList.remove('open');
            document.getElementById('sidebarPanel').classList.remove('open');
        }
        
        function toggleSidebar() {
            const panel = document.getElementById('sidebarPanel');
            if (panel.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }
        
        // Make available globally
        window.toggleSidebar = toggleSidebar;
        window.openSidebar = openSidebar;
        window.closeSidebar = closeSidebar;
        
        // Close sidebar on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });
        
        // Close sidebar after Livewire navigate
        document.addEventListener('livewire:navigated', function() {
            closeSidebar();
        });
    </script>
    
    @livewireScripts
</body>
</html>
