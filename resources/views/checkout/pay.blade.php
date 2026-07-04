<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Complete Payment</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617;
            color: #001e40;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-bg {
            background: linear-gradient(-45deg, #020617, #004d40, #1e3a8a, #4c1d95, #020617);
            background-size: 200% 200%;
            animation: gradientShift 25s ease infinite;
        }
        @keyframes blob1 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(80px, -100px) scale(1.25) rotate(45deg); }
            66% { transform: translate(-50px, 60px) scale(0.75) rotate(-45deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        .animate-blob {
            animation: blob1 15s infinite alternate ease-in-out;
        }

        .payment-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 28px;
            padding: 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0px 25px 60px rgba(0, 30, 64, 0.15);
            position: relative;
            z-index: 10;
        }

        .plan-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: rgba(0, 106, 106, 0.08);
            border: 1px solid rgba(0, 106, 106, 0.15);
            color: #006a6a;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(0, 106, 106, 0.15), transparent);
            margin: 24px 0;
        }

        #card-element {
            background: rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 106, 106, 0.15);
            border-radius: 12px;
            padding: 16px;
            transition: all 0.25s ease-in-out;
        }

        #card-element.StripeElement--focus {
            background: #ffffff;
            border-color: #006a6a;
            box-shadow: 0 0 0 3px rgba(0, 106, 106, 0.15);
        }

        #card-element.StripeElement--invalid {
            border-color: #ef4444;
        }

        .StripeElement--webkit-autofill {
            background-color: transparent !important;
        }

        #card-errors {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
            min-height: 20px;
        }

        .uiverse-btn-wrapper {
            width: 100%;
            max-width: 400px;
            height: 70px;
            margin: 0 auto;
            position: relative;
        }

        .uiverse-btn-container {
            background-color: #ffffff;
            display: flex;
            width: 100%;
            max-width: 400px;
            height: 70px;
            position: relative;
            border-radius: 14px;
            transition: 0.3s ease-in-out;
            border: 1px solid rgba(0, 106, 106, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            padding: 0;
            outline: none;
            overflow: hidden;
            margin: 0 auto;
        }

        .uiverse-btn-wrapper:hover .uiverse-btn-container:not(:disabled) {
            transform: scale(1.02);
            width: 180px;
            border-color: #006a6a;
            box-shadow: 0 10px 25px rgba(0, 106, 106, 0.15);
        }

        .uiverse-btn-container:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .uiverse-btn-wrapper:hover .uiverse-btn-container:not(:disabled) .left-side {
            width: 100%;
        }

        .left-side {
            background-color: #5de2a3;
            width: 80px;
            height: 70px;
            border-radius: 12px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
            flex-shrink: 0;
            overflow: hidden;
        }

        .right-side {
            width: calc(100% - 80px);
            display: flex;
            align-items: center;
            overflow: hidden;
            cursor: pointer;
            justify-content: space-between;
            white-space: nowrap;
            transition: 0.3s;
            height: 100%;
        }

        .right-side:hover {
            background-color: #f9f7f9;
        }

        .arrow {
            width: 16px;
            height: 16px;
            margin-right: 20px;
        }

        .new {
            font-size: 16px;
            font-weight: 700;
            color: #001e40;
            font-family: 'Inter', sans-serif;
            margin-left: 20px;
        }

        .card {
            width: 44px;
            height: 30px;
            background-color: #c7ffbc;
            border-radius: 4px;
            position: absolute;
            display: flex;
            z-index: 10;
            flex-direction: column;
            align-items: center;
            box-shadow: 4px 4px 6px -2px rgba(77, 200, 143, 0.5);
        }

        .card-line {
            width: 38px;
            height: 8px;
            background-color: #80ea69;
            border-radius: 1px;
            margin-top: 5px;
        }

        .buttons {
            width: 5px;
            height: 5px;
            background-color: #379e1f;
            box-shadow: 0 -5px 0 0 #26850e, 0 5px 0 0 #56be3e;
            border-radius: 50%;
            margin-top: 3px;
            transform: rotate(90deg);
            margin: 5px 0 0 -15px;
        }

        .uiverse-btn-wrapper:hover .uiverse-btn-container:not(:disabled) .card {
            animation: slide-top 1.2s cubic-bezier(0.645, 0.045, 0.355, 1) both;
        }

        .uiverse-btn-wrapper:hover .uiverse-btn-container:not(:disabled) .post {
            animation: slide-post 1s cubic-bezier(0.165, 0.84, 0.44, 1) both;
        }

        @keyframes slide-top {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-45px) rotate(90deg);
            }
            60% {
                transform: translateY(-45px) rotate(90deg);
            }
            100% {
                transform: translateY(-6px) rotate(90deg);
            }
        }

        .post {
            width: 40px;
            height: 48px;
            background-color: #dddde0;
            position: absolute;
            z-index: 11;
            bottom: 6px;
            top: 70px;
            border-radius: 4px;
            overflow: hidden;
        }

        .post-line {
            width: 30px;
            height: 6px;
            background-color: #545354;
            position: absolute;
            border-radius: 0px 0px 2px 2px;
            right: 5px;
            top: 5px;
        }

        .post-line:before {
            content: "";
            position: absolute;
            width: 30px;
            height: 6px;
            background-color: #757375;
            top: -5px;
        }

        .screen {
            width: 30px;
            height: 14px;
            background-color: #ffffff;
            position: absolute;
            top: 14px;
            right: 5px;
            border-radius: 2px;
        }

        .numbers {
            width: 6px;
            height: 6px;
            background-color: #838183;
            box-shadow: 0 -10px 0 0 #838183, 0 10px 0 0 #838183;
            border-radius: 1px;
            position: absolute;
            transform: rotate(90deg);
            left: 17px;
            top: 32px;
        }

        .numbers-line2 {
            width: 6px;
            height: 6px;
            background-color: #aaa9ab;
            box-shadow: 0 -10px 0 0 #aaa9ab, 0 10px 0 0 #aaa9ab;
            border-radius: 1px;
            position: absolute;
            transform: rotate(90deg);
            left: 17px;
            top: 42px;
        }

        @keyframes slide-post {
            50% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-45px);
            }
        }

        .dollar {
            position: absolute;
            font-size: 11px;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            width: 100%;
            left: 0;
            top: 0;
            color: #4b953b;
            text-align: center;
        }

        .uiverse-btn-wrapper:hover .uiverse-btn-container:not(:disabled) .dollar {
            animation: fade-in-fwd 0.3s 1s backwards;
        }

        @keyframes fade-in-fwd {
            0% {
                opacity: 0;
                transform: translateY(-3px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .price-amount {
            font-size: 36px;
            font-weight: 700;
            color: #006a6a;
        }

        .back-link {
            color: rgba(0, 30, 64, 0.6);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #006a6a;
        }
    </style>
</head>
<body>
    <!-- Vibrant animated gradient background -->
    <div class="absolute inset-0 animate-gradient-bg overflow-hidden z-0">
        <div class="absolute top-[10%] left-[20%] w-[500px] h-[500px] bg-[#00f5d4]/20 rounded-full filter blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[10%] right-[20%] w-[600px] h-[600px] bg-[#3b82f6]/15 rounded-full filter blur-[140px] animate-blob" style="animation-delay: 3s;"></div>
    </div>

    <div class="payment-card">
        <div class="text-center mb-8">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA Logo" class="h-28 w-auto object-contain mx-auto mb-4 drop-shadow-sm">
            <h1 class="text-2xl font-black text-[#001e40] tracking-tight">Complete Payment</h1>
        </div>

        <div class="flex items-center justify-between mb-2">
            <span class="text-zinc-500 font-medium">Plan</span>
            <span class="plan-badge">{{ $plan->name }}</span>
        </div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-zinc-500 font-medium">Billing</span>
            <span class="text-[#001e40] font-bold capitalize">{{ $order->plan_period === 'one_time' ? 'One-time Payment' : str_replace('_', ' ', $order->plan_period) }}</span>
        </div>

        <div class="divider"></div>

        <div class="flex items-center justify-between mb-8">
            <span class="text-zinc-500 text-lg font-medium">Total</span>
            <span>
                <span class="price-amount">${{ number_format($order->amount / 100, 2) }}</span>
            </span>
        </div>

        <form id="payment-form" class="space-y-4">
            <div>
                <label class="text-sm text-zinc-600 mb-2 block font-bold">Card Details</label>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>

            <div class="uiverse-btn-wrapper">
                <button id="submit-button" type="submit" class="uiverse-btn-container" disabled>
                    <div class="left-side">
                        <div class="card">
                            <div class="card-line"></div>
                            <div class="buttons"></div>
                        </div>
                        <div class="post">
                            <div class="post-line"></div>
                            <div class="screen">
                                <div class="dollar">$</div>
                            </div>
                            <div class="numbers"></div>
                            <div class="numbers-line2"></div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="new" id="button-text">Pay ${{ number_format($order->amount / 100, 2) }}</div>
                        <svg viewBox="0 0 451.846 451.847" height="512" width="512" xmlns="http://www.w3.org/2000/svg" class="arrow"><path fill="#cfcfcf" data-old_color="#000000" class="active-path" data-original="#000000" d="M345.441 248.292L151.154 442.573c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744L278.318 225.92 106.409 54.017c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.287 194.284c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373z"></path></svg>
                    </div>
                </button>
            </div>
            <p class="text-xs text-zinc-500 text-center mt-2 font-bold tracking-wide">
                Click to confirm payment
            </p>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('pricing') }}" class="back-link">← Back to plans</a>
        </div>

        <p class="text-xs text-zinc-400 text-center mt-4">
            Secured by Stripe. Your card details never touch our servers.
        </p>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    fontFamily: '"Inter", sans-serif',
                    color: '#001e40',
                    '::placeholder': {
                        color: 'rgba(0,30,64,0.4)',
                    },
                },
                invalid: {
                    color: '#ef4444',
                },
            },
        });

        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const cardErrors = document.getElementById('card-errors');

        cardElement.on('change', (event) => {
            submitButton.disabled = !event.complete;
            if (event.error) {
                cardErrors.textContent = event.error.message;
            } else {
                cardErrors.textContent = '';
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true;
            buttonText.innerHTML = '<span class="spinner"></span> Processing…';

            const { error, paymentIntent } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                payment_method: {
                    card: cardElement,
                },
            });

            if (error) {
                cardErrors.textContent = error.message;
                buttonText.textContent = 'Pay ${{ number_format($order->amount / 100, 2) }}';
                submitButton.disabled = false;
            } else if (paymentIntent.status === 'succeeded') {
                window.location.href = '{{ route("checkout.success") }}';
            }
        });
    </script>
</body>
</html>
