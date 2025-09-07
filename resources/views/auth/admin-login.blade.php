<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - {{ config('app.name') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .logo i {
            font-size: 32px;
            color: white;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #718096;
            font-size: 16px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 400;
            color: #2d3748;
            background: #f7fafc;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
            z-index: 2;
        }

        .form-input:focus + .input-icon {
            color: #667eea;
        }

        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-input.error {
            border-color: #e53e3e;
            background: #fed7d7;
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-checkbox input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
            cursor: pointer;
        }

        .custom-checkbox input:checked + .checkmark {
            background: #667eea;
            border-color: #667eea;
        }

        .custom-checkbox input:checked + .checkmark::after {
            opacity: 1;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .checkmark::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .checkbox-label {
            color: #4a5568;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #f0fff4;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .alert-error {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #feb2b2;
        }

        .alert i {
            font-size: 18px;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #5a67d8;
        }

        .footer-links {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .footer-links a {
            color: #718096;
            text-decoration: none;
            font-size: 14px;
            margin: 0 12px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #667eea;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
                border-radius: 16px;
            }

            .login-title {
                font-size: 24px;
            }

            .form-input {
                padding: 14px 16px 14px 45px;
                font-size: 16px;
            }

            .input-icon {
                left: 14px;
                font-size: 16px;
            }

            .remember-forgot {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .login-container {
                background: rgba(26, 32, 44, 0.95);
                color: #e2e8f0;
            }

            .login-title {
                color: #f7fafc;
            }

            .login-subtitle {
                color: #a0aec0;
            }

            .form-label {
                color: #e2e8f0;
            }

            .form-input {
                background: #2d3748;
                border-color: #4a5568;
                color: #e2e8f0;
            }

            .form-input:focus {
                background: #1a202c;
                border-color: #667eea;
            }

            .checkbox-label {
                color: #cbd5e0;
            }

            .footer-links {
                border-color: #4a5568;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <a href="{{ url('/') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Site
        </a>

        <div class="logo-section">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1 class="login-title">Admin Login</h1>
            <p class="login-subtitle">Access your admin dashboard</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.store') }}" method="POST" id="loginForm">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-input @error('email') error @enderror" 
                           placeholder="Enter your email address"
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-input @error('password') error @enderror" 
                           placeholder="Enter your password"
                           required>
                    <i class="fas fa-lock input-icon"></i>
                </div>
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="remember-forgot">
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <div class="checkmark"></div>
                    </div>
                    <label for="remember" class="checkbox-label">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="login-button" id="loginButton">
                <div class="loading-spinner" id="loadingSpinner"></div>
                <i class="fas fa-sign-in-alt" id="loginIcon"></i>
                <span id="loginText">Sign In</span>
            </button>
        </form>

        <div class="footer-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('seller.login') }}">Seller Login</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loginIcon = document.getElementById('loginIcon');
            const loginText = document.getElementById('loginText');

            form.addEventListener('submit', function() {
                // Show loading state
                loginButton.disabled = true;
                loadingSpinner.style.display = 'block';
                loginIcon.style.display = 'none';
                loginText.textContent = 'Signing In...';
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                });
            }, 5000);

            // Add smooth transitions to alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'all 0.3s ease';
            });

            // Password visibility toggle (optional enhancement)
            const passwordInput = document.getElementById('password');
            const passwordIcon = passwordInput.nextElementSibling;
            
            passwordIcon.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.className = 'fas fa-eye-slash input-icon';
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.className = 'fas fa-lock input-icon';
                }
            });
        });
    </script>
</body>
</html>
