<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FamilyTree Pro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-bg {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1E1B4B 0%, #4F46E5 100%);
            padding: 20px;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 24px 48px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }
        .auth-brand {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-icon {
            width: 56px;
            height: 56px;
            background: rgba(79,70,229,0.1);
            color: #4F46E5;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.5rem;
        }
        .auth-brand h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1E293B;
            letter-spacing: -0.02em;
        }
        .auth-brand p {
            font-size: 0.875rem;
            color: #64748B;
            margin-top: 4px;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-brand">
                <a href="/" class="auth-icon">
                    <i class="fas fa-sitemap"></i>
                </a>
                <h1>FamilyTree Pro</h1>
                <p>Preserve your legacy, digitize your history.</p>
            </div>

            <div>
                {{ $slot }}
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <a href="/" class="text-xs font-semibold text-muted hover:text-primary transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Homepage
                </a>
            </div>
        </div>
    </div>
</body>
</html>
