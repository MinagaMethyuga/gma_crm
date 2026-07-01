<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Payment Successful</title>
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

        /* Subtle ambient lighting */
        .ambient-light {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 106, 106, 0.15) 0%, rgba(0, 85, 255, 0.08) 50%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
            animation: pulse-light 8s ease-in-out infinite alternate;
        }

        @keyframes pulse-light {
            0% { opacity: 0.7; transform: translate(-50%, -50%) scale(0.95); }
            100% { opacity: 1; transform: translate(-50%, -50%) scale(1.05); }
        }

        /* Executive Card */
        .success-card {
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
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 30px -5px rgba(0, 106, 106, 0.2);
            transition: all 0.4s var(--smooth);
            text-align: center;
        }
        .success-card:hover {
            border-color: rgba(64, 224, 208, 0.25);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8), 0 0 40px -5px rgba(64, 224, 208, 0.25);
            transform: translateY(-2px);
        }

        /* Staggered Animations */
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
        .animate-fade-up-4 { opacity: 0; transform: translateY(16px); animation: fade-up 0.6s var(--smooth) 0.6s forwards; }

        @keyframes card-in {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes icon-in {
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes fade-up {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Professional Checkmark Badge */
        .icon-badge {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(0, 106, 106, 0.25));
            border: 1px solid rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            position: relative;
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.25);
        }
        
        .checkmark-svg {
            width: 34px;
            height: 34px;
            stroke: #10b981;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: draw-check 0.7s var(--smooth) 0.35s forwards;
        }
        @keyframes draw-check {
            to { stroke-dashoffset: 0; }
        }

        /* Structured Summary Panel */
        .summary-panel {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 20px;
            margin-top: 24px;
            margin-bottom: 28px;
            text-align: left;
            transition: border-color 0.3s ease, background 0.3s ease;
        }
        .summary-panel:hover {
            border-color: rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.045);
        }

        /* Live Indicator Dot */
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            position: relative;
            display: inline-block;
            margin-right: 6px;
        }
        .status-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background-color: #10b981;
            opacity: 0.5;
            animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes ping {
            75%, 100% { transform: scale(2.2); opacity: 0; }
        }

        /* Executive Button */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px 28px;
            border-radius: 12px;
            background: linear-gradient(135deg, #006a6a, #009090);
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 106, 106, 0.3);
            transition: all 0.25s var(--smooth);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 106, 106, 0.5);
            background: linear-gradient(135deg, #007a7a, #00a0a0);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="ambient-light"></div>

    <div class="success-card animate-card-in">
        <!-- Professional Animated Checkmark Icon -->
        <div class="icon-badge animate-icon-in">
            <svg class="checkmark-svg" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1 class="text-2xl font-bold mb-2 tracking-tight text-white animate-fade-up-1">
            Payment Successful
        </h1>
        
        <p class="text-zinc-400 text-sm mb-2 animate-fade-up-2 leading-relaxed">
            Thank you for your payment. Your Global Mobile Association membership is now active and benefits are unlocked.
        </p>

        <!-- Structured Order / Plan Details Panel -->
        <div class="summary-panel animate-fade-up-3">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/10" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 12px; margin-bottom: 12px;">
                <span class="text-xs uppercase tracking-wider text-zinc-400 font-semibold" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600;">Status</span>
                <span class="inline-flex items-center text-xs font-semibold text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20" style="display: inline-flex; align-items: center; font-size: 12px; font-weight: 600; color: #34d399; background: rgba(16, 185, 129, 0.1); padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <span class="status-dot"></span> Active Member
                </span>
            </div>

            @php
                $activePlan = null;
                if(isset($order) && $order && $order->plan) {
                    $activePlan = $order->plan->name;
                } elseif(isset($user) && $user && $user->plan) {
                    $activePlan = $user->plan->name;
                }
            @endphp

            <div class="flex items-center justify-between mb-2.5" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span class="text-sm text-zinc-400" style="font-size: 13px; color: #94a3b8;">Membership Plan</span>
                <span class="text-sm font-semibold text-white" style="font-size: 13px; font-weight: 600; color: #ffffff;">{{ $activePlan ?? 'Professional Plan' }}</span>
            </div>

            @if(isset($order) && $order)
            <div class="flex items-center justify-between mb-2.5" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span class="text-sm text-zinc-400" style="font-size: 13px; color: #94a3b8;">Order Reference</span>
                <span class="text-xs font-mono bg-white/5 px-2 py-0.5 rounded text-zinc-300" style="font-family: 'JetBrains Mono', monospace; font-size: 12px; background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 4px; color: #cbd5e1;">#GMA-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex items-center justify-between" style="display: flex; justify-content: space-between; align-items: center;">
                <span class="text-sm text-zinc-400" style="font-size: 13px; color: #94a3b8;">Amount Paid</span>
                <span class="text-sm font-semibold text-emerald-400" style="font-size: 13px; font-weight: 600; color: #34d399;">${{ number_format($order->amount / 100, 2) }} {{ strtoupper($order->currency ?? 'USD') }}</span>
            </div>
            @else
            <div class="flex items-center justify-between" style="display: flex; justify-content: space-between; align-items: center;">
                <span class="text-sm text-zinc-400" style="font-size: 13px; color: #94a3b8;">Activation Date</span>
                <span class="text-sm font-semibold text-zinc-200" style="font-size: 13px; font-weight: 600; color: #e2e8f0;">{{ now()->format('M d, Y') }}</span>
            </div>
            @endif
        </div>

        <div class="animate-fade-up-4">
            <a href="{{ route('member.dashboard') }}" class="btn-primary">
                Go to Member Dashboard →
            </a>
        </div>
    </div>
</body>
</html>
