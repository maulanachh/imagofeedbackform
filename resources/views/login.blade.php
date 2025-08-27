<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .error,
        .success {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
        }

        .error {
            background: #f8d7da;
            color: #842029;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <h2>Login</h2>

        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            @error('username')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="email" name="email" placeholder="Email" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Login</button>
        </form>

        <div class="link">
            Belum punya akun? <a href="{{ route('register') }}">Register</a>
        </div>
    </div>
</body>

</html>
