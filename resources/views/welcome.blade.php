<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FamilyTree Pro — Your Digital Ancestry</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);
            color: white;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }
        .hero-blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(79,70,229,0.2) 0%, rgba(79,70,229,0) 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: pulse 10s infinite alternate;
        }
        @keyframes pulse {
            from { transform: scale(1); opacity: 0.5; }
            to { transform: scale(1.2); opacity: 0.8; }
        }
        .glass-nav {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1000px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
        }
        .hero-content {
            text-align: center;
            max-width: 800px;
            z-index: 1;
        }
        .hero-content h1 {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 800;
            line-height:1.1;
            margin-bottom: 24px;
            background: linear-gradient(to right, #fff, #A5B4FC);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-content p {
            font-size: 1.25rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 40px;
        }
        .cta-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-glass {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-glass:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .btn-white {
            background: white;
            color: #1E1B4B;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-blob"></div>
        
        <nav class="glass-nav">
            <div class="flex items-center gap-2">
                <i class="fas fa-sitemap text-primary"></i>
                <span class="font-bold text-white tracking-tight">FamilyTree Pro</span>
            </div>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white/70 hover:text-white transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-white/70 hover:text-white transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-white/70 hover:text-white transition">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <div class="hero-content">
            <span class="inline-block px-4 py-1.5 bg-primary/20 text-primary-light rounded-full text-xs font-bold uppercase tracking-widest mb-6">Experience the Legacy</span>
            <h1>Digitize Your Family History</h1>
            <p>Build, visualize, and preserve your family legacy with the world's most intuitive digital ancestry platform.</p>
            
            <div class="cta-group">
                <a href="{{ route('register') }}" class="btn-white">Start Your Tree</a>
                <a href="#features" class="btn-glass">Learn More</a>
            </div>
        </div>
    </div>
</body>
</html>
