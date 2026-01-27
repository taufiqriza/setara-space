<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }} - Setara Space POS</title>
    
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
        body { font-family: 'Outfit', sans-serif; }
        
        /* Animated gradient background */
        .gradient-bg {
            background: linear-gradient(-45deg, #3B4CCA, #6b5cfa, #5b3def, #2d2a8c);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
    
    @livewireStyles
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Floating Particles -->
    <div class="particle w-32 h-32 top-10 left-10" style="animation-delay: 0s;"></div>
    <div class="particle w-20 h-20 top-1/4 right-20" style="animation-delay: 2s;"></div>
    <div class="particle w-16 h-16 bottom-20 left-1/4" style="animation-delay: 4s;"></div>
    <div class="particle w-24 h-24 bottom-10 right-10" style="animation-delay: 1s;"></div>
    <div class="particle w-12 h-12 top-1/2 left-20" style="animation-delay: 3s;"></div>
    
    {{ $slot }}
    
    @livewireScripts
</body>
</html>
