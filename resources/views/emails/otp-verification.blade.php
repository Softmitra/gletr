<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification OTP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .otp-section {
            text-align: center;
            margin: 30px 0;
        }

        .otp-code {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            font-size: 36px;
            font-weight: bold;
            padding: 20px 30px;
            border-radius: 10px;
            display: inline-block;
            letter-spacing: 8px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .otp-label {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .instructions {
            background-color: #f8f9fa;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }

        .instructions h3 {
            color: #f59e0b;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .instructions ul {
            list-style: none;
            padding-left: 0;
        }

        .instructions li {
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }

        .instructions li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #f59e0b;
            font-weight: bold;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .warning strong {
            display: block;
            margin-bottom: 5px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer a {
            color: #f59e0b;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .security-note {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            color: #1565c0;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }

            .header, .content, .footer {
                padding: 20px;
            }

            .otp-code {
                font-size: 28px;
                padding: 15px 20px;
                letter-spacing: 6px;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🔐 Email Verification</h1>
            <p>Complete your account verification</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Hello!</h2>
            <p>Thank you for registering with <strong>{{ config('app.name') }}</strong>. To complete your account setup, please verify your email address using the OTP below.</p>

            <!-- OTP Section -->
            <div class="otp-section">
                <div class="otp-label">Your verification code is:</div>
                <div class="otp-code">{{ $otp }}</div>
                <p style="color: #666; font-size: 14px;">This code will expire in {{ $expires_in }} minutes</p>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h3>How to verify your email:</h3>
                <ul>
                    <li>Copy the 6-digit code above</li>
                    <li>Return to the verification page</li>
                    <li>Enter the code in the OTP field</li>
                    <li>Click "Verify Email" to complete</li>
                </ul>
            </div>

            <!-- Security Note -->
            <div class="security-note">
                <strong>🔒 Security Notice:</strong> Never share this OTP with anyone. Our team will never ask for your verification code.
            </div>

            <!-- Warning -->
            <div class="warning">
                <strong>⏰ Important:</strong> This verification code will expire in {{ $expires_in }} minutes for security reasons. If you don't verify your email within this time, you'll need to request a new code.
            </div>

            <p>If you didn't request this verification code, please ignore this email or contact our support team if you have concerns.</p>

            <p>Best regards,<br>
            <strong>The {{ config('app.name') }} Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This email was sent to <strong>{{ $email }}</strong></p>
            <p>If you have any questions, please contact our support team.</p>
            <p>
                <a href="{{ url('/') }}">Visit our website</a> | 
                <a href="{{ url('/contact') }}">Contact Support</a>
            </p>
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
