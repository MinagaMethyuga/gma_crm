<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        @keyframes blob1 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(100px, -150px) scale(1.3) rotate(60deg); }
            66% { transform: translate(-60px, 80px) scale(0.7) rotate(-60deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        @keyframes blob2 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(-120px, 100px) scale(0.7) rotate(-90deg); }
            66% { transform: translate(80px, -130px) scale(1.3) rotate(90deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        @keyframes blob3 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            50% { transform: translate(120px, 120px) scale(1.2) rotate(180deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        .animate-blob-1 {
            animation: blob1 14s infinite alternate ease-in-out;
        }
        .animate-blob-2 {
            animation: blob2 16s infinite alternate ease-in-out;
        }
        .animate-blob-3 {
            animation: blob3 20s infinite alternate ease-in-out;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .auth-form-enter {
            animation: formFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes formFadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Stagger field animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-stagger-item {
            opacity: 0;
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        .delay-600 { animation-delay: 600ms; }
        .delay-700 { animation-delay: 700ms; }
        .delay-800 { animation-delay: 800ms; }
    </style>
</head>
<body class="min-h-screen antialiased bg-[#020617] text-white overflow-x-hidden flex items-center justify-center relative">
    @include('components.page-transition')

    <!-- Dark gradient background with highly kinetic rich neon blobs -->
    <div class="absolute inset-0 bg-gradient-to-br from-[#010409] via-[#020c1b] to-[#05162e] overflow-hidden">
        <div class="absolute top-[-10%] left-[-15%] w-[600px] h-[600px] bg-[#40e0d0]/12 rounded-full filter blur-[150px] animate-blob-1"></div>
        <div class="absolute bottom-[-10%] right-[-15%] w-[700px] h-[700px] bg-[#006a6a]/20 rounded-full filter blur-[180px] animate-blob-2 animation-delay-2000"></div>
        <div class="absolute top-[20%] right-[10%] w-[500px] h-[500px] bg-[#009090]/15 rounded-full filter blur-[130px] animate-blob-3 animation-delay-4000"></div>
        <div class="absolute bottom-[20%] left-[10%] w-[450px] h-[450px] bg-[#40e0d0]/10 rounded-full filter blur-[120px] animate-blob-1 animation-delay-2000"></div>
    </div>

    <!-- Decorative grid overlay -->
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle at 1px 1px, #40e0d0 1px, transparent 0); background-size: 40px 40px;"></div>

    <!-- Auth Card container: widened to max-w-xl and set to light glassmorphism for logo visibility -->
    <div class="relative z-10 w-full max-w-xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
        <div class="auth-form-enter bg-white/90 backdrop-blur-3xl rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,30,64,0.25)] border border-white/60 p-8 sm:p-12">
            {{ $slot }}
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>