<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            max-width: 400px;
            margin: 5rem auto;
            padding: 2rem 2.5rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #111827;
        }

        .auth-info {
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 1rem;
            text-align: center;
        }

        .auth-errors {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .auth-errors ul {
            margin: 0;
            padding-left: 1.2rem;
        }

        .auth-form input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .auth-form input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .auth-actions {
            text-align: right;
        }

        .auth-btn {
            background: #6366f1;
            color: #fff;
            font-weight: 600;
            padding: 0.65rem 1.2rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .auth-btn:hover {
            background: #4f46e5;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .auth-footer a {
            color: #6366f1;
            font-weight: 500;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <h2 class="auth-title">Forgot Password</h2>

        <p class="auth-info">
            Enter your email address and we will send you a link to reset your password.
        </p>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="auth-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="auth-info"
                style="color:#065f46; background:#d1fae5; border:1px solid #6ee7b7; padding:0.8rem 1rem; border-radius:8px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>

            <div class="auth-actions">
                <button type="submit" class="auth-btn">Send Password Reset Link</button>
            </div>
        </form>

        <p class="auth-footer">
            Remembered your password? <a href="{{ route('login') }}">Login here</a>.
        </p>
    </div>
</body>

</html>