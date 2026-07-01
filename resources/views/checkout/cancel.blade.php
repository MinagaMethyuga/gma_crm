<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Payment Cancelled</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --spring: cubic-bezier(0.34, 1.56, 0.64, 1);
            --smooth: cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #060b14;
            color: #ffffff;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        .ambient-light {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 51, 102, 0.1) 0%, rgba(0, 30, 64, 0.08) 50%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
        }

        .cancel-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.75) 0%, rgba(10, 15, 29, 0.85) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 48px 40px;
            max-width: 480px;
            width: calc(100% - 32px);
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 30px -5px rgba(255, 51, 102, 0.15);
            transition: all 0.4s var(--smooth);
            text-align: center;
        }
        .cancel-card:hover {
            border-color: rgba(255, 51, 102, 0.25);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8), 0 0 40px -5px rgba(255, 51, 102, 0.2);
            transform: translateY(-2px);
        }

        .animate-card-in {
            opacity: 0;
            transform: translateY(24px) scale(0.98);
            animation: card-in 0.7s var(--smooth) forwards;
        }
        .animate-icon-in {
            opacity: 0;
            transform: scale(0.6);
            animation: icon-in 0.7s var(--spring) 0.15s forwards;
        }
        .animate-fade-up-1 { opacity: 0; transform: translateY(16px); animation: fade-up 0.6s var(--smooth) 0.3s forwards; }
        .animate-fade-up-2 { opacity: 0; transform: translateY(16px); animation: fade-up 0.6s var(--smooth) 0.4s forwards; }
        .animate-fade-up-3 { opacity: 0; transform: translateY(16px); animation: fade-up 0.6s var(--smooth) 0.5s forwards; }

        @keyframes card-in { to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes icon-in { to { opacity: 1; transform: scale(1); } }
        @keyframes fade-up { to { opacity: 1; transform: translateY(0); } }

        .icon-badge {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 51, 102, 0.15), rgba(0, 30, 64, 0.25));
            border: 1px solid rgba(255, 51, 102, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            position: relative;
            box-shadow: 0 0 25px rgba(255, 51, 102, 0.2);
        }

        .btn-return {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px 28px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0055ff, #0077ff);
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 85, 255, 0.3);
            transition: all 0.25s var(--smooth);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 85, 255, 0.5);
            background: linear-gradient(135deg, #0066ff, #0088ff);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .btn-return:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="ambient-light"></div>

    <div class="cancel-card animate-card-in">
        <div class="icon-badge animate-icon-in">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff3366" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>

        <h1 class="text-2xl font-bold mb-2 tracking-tight text-white animate-fade-up-1">
            Payment Cancelled
        </h1>
        
        <p class="text-zinc-400 text-sm mb-8 animate-fade-up-2 leading-relaxed">
            Your checkout session was cancelled and no charges were made. Your plan selection has been saved whenever you are ready to complete your upgrade.
        </p>

        <div class="animate-fade-up-3">
            <a href="{{ route('pricing') }}" class="btn-return">
                ← Return to Plans
            </a>
        </div>
    </div>
</body>
</html>
