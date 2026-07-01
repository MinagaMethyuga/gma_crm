<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMA - Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Glassmorphic cards for the left side */
        .cc-stack-container {
            perspective: 1200px;
        }
        .cc-card {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.4);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            transform-style: preserve-3d;
        }
        .cc-stack-container:hover .cc-card-1 { transform: rotateX(45deg) rotateZ(-15deg) translateZ(100px) translateY(-20px); }
        .cc-stack-container:hover .cc-card-2 { transform: rotateX(45deg) rotateZ(-15deg) translateZ(50px) translateY(0px); }
        .cc-stack-container:hover .cc-card-3 { transform: rotateX(45deg) rotateZ(-15deg) translateZ(0px) translateY(20px); }
        
        .cc-card-1 { transform: rotateX(55deg) rotateZ(-20deg) translateZ(80px) translateY(-10px); }
        .cc-card-2 { transform: rotateX(55deg) rotateZ(-20deg) translateZ(40px) translateY(10px); }
        .cc-card-3 { transform: rotateX(55deg) rotateZ(-20deg) translateZ(0px) translateY(30px); }

        /* Animation utilities */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        @keyframes header-spring-in {
            0% { transform: translateY(-100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-header-spring {
            animation: header-spring-in 800ms cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        
        /* Custom Input Styling */
        .payment-input {
            width: 100%;
            height: 48px;
            padding: 0 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s ease;
            background: white;
        }
        .payment-input:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
        }
        .payment-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
        }
        .payment-label span {
            color: #a855f7;
        }
        
        /* Quick Pay Button */
        .quick-pay-btn {
            height: 44px;
            border: 1px solid #f1f5f9;
            background: #f8fafc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }
        .quick-pay-btn:hover {
            background: #f1f5f9;
            border-color: #e2e8f0;
        }
    </style>
</head>
<body class="overflow-hidden text-slate-800 bg-[#fbfcfd]">

    <div class="h-screen w-full flex items-center justify-center p-4 md:p-10 relative">
        <!-- Optional Background Decoration -->
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-slate-50 to-slate-100/50"></div>

        <div class="w-full max-w-[1000px] bg-white rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] overflow-hidden flex flex-col md:flex-row min-h-[600px] animate-on-scroll border border-slate-200/50 relative z-10">
                    
                    <!-- Left Column (Visuals) -->
                    <div class="md:w-[45%] relative bg-[#0a1128] overflow-hidden hidden md:flex flex-col items-center justify-center p-12">
                        <!-- Glows -->
                        <div class="absolute top-[10%] left-[0%] w-[80%] h-[80%] bg-[#a855f7]/40 rounded-full blur-[100px] opacity-70 animate-pulse"></div>
                        <div class="absolute bottom-[0%] right-[0%] w-[70%] h-[70%] bg-[#3b82f6]/30 rounded-full blur-[80px] opacity-60"></div>
                        
                        <!-- Credit Card Stack -->
                        <div class="cc-stack-container w-full max-w-[340px] aspect-[1.586] relative z-10 mt-8">
                            <!-- Card 1 (Bottom - Purple/Pink) -->
                            <div class="cc-card cc-card-3 absolute inset-0 rounded-2xl bg-gradient-to-br from-[#ec4899] via-[#d946ef] to-[#8b5cf6] p-6 text-white flex flex-col justify-between border border-white/20">
                                <div class="font-bold text-xl italic tracking-wider">Mastercard</div>
                                <div>
                                    <div class="font-mono text-[17px] tracking-widest mb-1 opacity-90 drop-shadow-md">4455 5491 6118 6164</div>
                                    <div class="text-[10px] uppercase opacity-70 tracking-wider">Edward Hunt</div>
                                </div>
                            </div>
                            
                            <!-- Card 2 (Middle - Blue/Indigo) -->
                            <div class="cc-card cc-card-2 absolute inset-0 rounded-2xl bg-gradient-to-br from-[#818cf8] to-[#4f46e5] p-6 text-white flex flex-col justify-between border border-white/20 shadow-2xl">
                                <div class="font-bold text-xl italic tracking-wider">VISA</div>
                                <div>
                                    <div class="font-mono text-[17px] tracking-widest mb-1 opacity-90 drop-shadow-md">4455 5491 6118 6164</div>
                                    <div class="text-[10px] uppercase opacity-70 tracking-wider">Edward Hunt</div>
                                </div>
                            </div>
                            
                            <!-- Card 3 (Top - Glass) -->
                            <div class="cc-card cc-card-1 absolute inset-0 rounded-2xl bg-white/10 p-6 text-white flex flex-col justify-between border border-white/30 shadow-2xl backdrop-blur-md">
                                <div class="font-bold text-xl italic tracking-wider text-white">VISA</div>
                                <div>
                                    <div class="font-mono text-[17px] tracking-widest mb-1 text-white text-shadow-sm drop-shadow-md">4455 5491 6118 6164</div>
                                    <div class="text-[10px] uppercase text-white/80 tracking-wider">Edward Hunt</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Form) -->
                    <div class="md:w-[55%] p-8 md:p-14 flex flex-col justify-center bg-white">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-[22px] font-bold text-slate-900 tracking-tight">Payment details</h2>
                            <button class="flex items-center gap-1.5 text-xs font-semibold text-[#a855f7] bg-[#f3e8ff] px-3 py-1.5 rounded-lg hover:bg-[#e9d5ff] transition-colors border border-purple-100">
                                <span class="material-symbols-outlined text-[16px]">qr_code_scanner</span>
                                QR code
                            </button>
                        </div>

                        <!-- Quick Pay -->
                        <div class="grid grid-cols-3 gap-3 mb-8">
                            <button class="quick-pay-btn">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="G" class="w-4 h-4">
                                Google Pay
                            </button>
                            <button class="quick-pay-btn">
                                <svg class="w-[18px] h-[18px]" viewBox="0 0 384 512" fill="#000"><path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/></svg>
                                Apple Pay
                            </button>
                            <button class="quick-pay-btn">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="#003087"><path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106z"/></svg>
                                PayPal
                            </button>
                        </div>

                        <!-- Divider -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-px bg-slate-200 flex-1"></div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Or</div>
                            <div class="h-px bg-slate-200 flex-1"></div>
                        </div>

                        <!-- Form -->
                        <form class="space-y-6" onsubmit="event.preventDefault();">
                            <!-- Card Number -->
                            <div>
                                <label class="payment-label">Card Number <span>*</span></label>
                                <div class="relative">
                                    <input type="text" class="payment-input tracking-[0.15em] font-mono text-[15px]" placeholder="5678    ****    ****    1267" value="5678    ****    ****    1267">
                                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <span class="material-symbols-outlined text-[18px]">visibility_off</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Holder Name -->
                            <div>
                                <label class="payment-label">Card Holder Name</label>
                                <input type="text" class="payment-input" placeholder="Cameron Williamson" value="Cameron Williamson">
                            </div>

                            <!-- Expiry & CVV -->
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="payment-label">Expiry Date <span>*</span></label>
                                    <input type="text" class="payment-input text-center tracking-wider" placeholder="mm / yy" value="10 / 25">
                                </div>
                                <div>
                                    <label class="payment-label">CVV/CVV2 <span>*</span></label>
                                    <div class="relative">
                                        <input type="password" class="payment-input text-center tracking-widest font-mono" placeholder="xxx" value="123">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 w-8 h-5 flex items-center justify-center opacity-90">
                                            <div class="w-3.5 h-3.5 rounded-full bg-[#eb001b] -mr-1 mix-blend-multiply"></div>
                                            <div class="w-3.5 h-3.5 rounded-full bg-[#f79e1b] mix-blend-multiply"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="h-px bg-slate-100 my-8"></div>

                            <!-- Total & Submit -->
                            <div class="flex items-center justify-between mb-5">
                                <span class="text-[15px] font-bold text-slate-700">Total Amount:</span>
                                <span class="text-[22px] font-bold text-[#a855f7]">$354</span>
                            </div>

                            <button type="submit" class="w-full h-[52px] bg-[#a855f7] hover:bg-[#9333ea] text-white rounded-xl font-semibold text-[15px] shadow-lg shadow-purple-500/25 transition-all hover:-translate-y-0.5">
                                Pay $354
                            </button>
                        </form>

                    </div>
                </div>
    </div>

    <!-- Optional: you could include settings modal if you want a settings gear, but usually checkout is standalone -->
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
