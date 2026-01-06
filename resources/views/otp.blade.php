<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <!-- Simple CSS for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .otp-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .error {
            color: #e74c3c;
        }

        .success {
            color: #2ecc71;
        }
    </style>
</head>
<body>

    <div class="otp-container">
        <h2>Verify Your Email</h2>

        @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Your Email" required value="{{ session('email') ?? '' }}">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>

</body>
</html>
