<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo {
            width: 100px;
            margin-bottom: 15px;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .social-login {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
        .social-btn {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }
        .google-btn { background: #db4437; }
        .facebook-btn { background: #3b5998; }
        .register-link {
            margin-top: 15px;
            display: block;
        }
        .error-message {
            color: red;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="{{ asset('Ps.png') }}" class="logo" alt="Logo">
        <h2>Login</h2>
        @if(session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="error-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn"><h2>Login</h2></button>
        </form>

        <div class="social-login">
    
            <a href="{{ route('auth.google') }}" class="social-btn google-btn"> <img src="{{ asset('google.png') }}" alt="Google" style="width: 20px; margin-right: 5px;">Login with Google
            </a>
            <a href="{{ route('auth.facebook') }}" class="social-btn facebook-btn"> <img src="{{ asset('fb.png') }}" alt="Facebook" style="width: 20px; margin-right: 5px;">Login with Facebook
            </a>
        </div>

        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </div>

</body>
</html>
