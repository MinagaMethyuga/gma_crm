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

    <!-- Back to Home Button -->
    <div class="fixed top-6 left-6 z-50">
        <a href="{{ route('home') }}" style="display:flex;height:3em;width:100px;align-items:center;justify-content:center;background:#fff;border-radius:6px;letter-spacing:1px;transition:all 0.2s linear;cursor:pointer;border:none;text-decoration:none;color:#001e40;font-weight:600;font-size:0.9rem;" onmouseover="this.style.boxShadow='9px 9px 33px #d1d1d1, -9px -9px 33px #ffffff';this.style.transform='translateY(-2px)';this.querySelector('svg').style.transform='translateX(-5px)';" onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)';this.querySelector('svg').style.transform='translateX(0)';">
            <svg style="margin-right:5px;margin-left:5px;transition:all 0.4s ease-in;" height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024"><path d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z" fill="#001e40"></path></svg>
            <span>Back</span>
        </a>
    </div>

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