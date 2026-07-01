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
            background-color: #001e40;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-card {
            background: linear-gradient(135deg, #002b4d 0%, #003c60 100%);
            border: 1px solid rgba(0, 106, 106, 0.4);
            border-radius: 24px;
            padding: 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0px -13px 300px 0px rgba(0, 106, 106, 0.3);
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
            background: rgba(0, 106, 106, 0.3);
            border: 1px solid rgba(64, 224, 208, 0.3);
            color: #40e0d0;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(64, 224, 208, 0.3), transparent);
            margin: 24px 0;
        }

        #card-element {
            background: #002b4d;
            border: 1px solid rgba(64, 224, 208, 0.2);
            border-radius: 12px;
            padding: 16px;
            transition: border-color 0.2s;
        }

        #card-element.StripeElement--focus {
            border-color: #40e0d0;
        }

        #card-element.StripeElement--invalid {
            border-color: #ef4444;
        }

        .StripeElement--webkit-autofill {
            background-color: #002b4d !important;
        }

        #card-errors {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
            min-height: 20px;
        }

        .pay-button {
            width: 100%;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 14px;
            background: linear-gradient(135deg, #006a6a, #009090);
            border: 1px solid rgba(64, 224, 208, 0.3);
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(0, 106, 106, 0.4);
        }

        .pay-button:hover:not(:disabled) {
            transform: scale(1.02);
            box-shadow: 0 6px 30px rgba(0, 106, 106, 0.6);
        }

        .pay-button:active:not(:disabled) {
            transform: scale(0.98);
        }

        .pay-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
            color: #40e0d0;
        }

        .back-link {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #40e0d0;
        }
    </style>
</head>
<body>
    <div class="payment-card">
        <div class="text-center mb-8">
            <img src="/Global_Mobile_Association_Logo__1_-removebg-preview.png" alt="GMA" class="h-12 mx-auto mb-4">
            <h1 class="text-2xl font-bold">Complete Payment</h1>
        </div>

        <div class="flex items-center justify-between mb-2">
            <span class="text-gray-300">Plan</span>
            <span class="plan-badge">{{ $plan->name }}</span>
        </div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-gray-300">Billing</span>
            <span class="text-white font-medium capitalize">{{ $order->plan_period }}</span>
        </div>

        <div class="divider"></div>

        <div class="flex items-center justify-between mb-8">
            <span class="text-gray-300 text-lg">Total</span>
            <span>
                <span class="price-amount">${{ number_format($order->amount / 100, 2) }}</span>
            </span>
        </div>

        <form id="payment-form" class="space-y-4">
            <div>
                <label class="text-sm text-gray-300 mb-2 block font-medium">Card Details</label>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>

            <button id="submit-button" class="pay-button">
                <span id="button-text">Pay ${{ number_format($order->amount / 100, 2) }}</span>
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('pricing') }}" class="back-link">← Back to plans</a>
        </div>

        <p class="text-xs text-gray-500 text-center mt-4">
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
                    color: '#ffffff',
                    '::placeholder': {
                        color: 'rgba(255,255,255,0.4)',
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
