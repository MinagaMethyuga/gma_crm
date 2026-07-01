<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMA - Payment Cancelled</title>
    <link rel="icon" href="/Global_Mobile_Association_Logo__1_-removebg-preview.png" type="image/png">
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
        .card {
            background: linear-gradient(135deg, #002b4d 0%, #003c60 100%);
            border: 1px solid rgba(0, 106, 106, 0.4);
            border-radius: 24px;
            padding: 48px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            box-shadow: 0px -13px 300px 0px rgba(0, 106, 106, 0.3);
        }
        .icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 28px;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 12px;
            background: linear-gradient(135deg, #006a6a, #009090);
            color: white;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✕</div>
        <h1 class="text-2xl font-bold mb-2">Payment Cancelled</h1>
        <p class="text-gray-300 mb-8">You've cancelled the payment. No charges were made.</p>
        <a href="{{ route('pricing') }}" class="btn">Back to Plans</a>
    </div>
</body>
</html>
