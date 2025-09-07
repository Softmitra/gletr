<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email - {{ $site_name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧪 Test Email</h1>
            <h2>{{ $site_name }}</h2>
        </div>
        
        <div class="content">
            <h3>SMTP Configuration Test</h3>
            <p>Hello,</p>
            <p>This is a test email from <strong>{{ $site_name }}</strong> to verify your SMTP configuration is working correctly.</p>
            
            <div class="details">
                <h4>📋 Test Details:</h4>
                <ul>
                    <li><strong>Email Type:</strong> {{ $type ?? 'Test' }}</li>
                    <li><strong>Event:</strong> {{ $event ?? 'Test Event' }}</li>
                    <li><strong>Sent At:</strong> {{ date('Y-m-d H:i:s') }}</li>
                    <li><strong>Test User:</strong> {{ $customer_name ?? $seller_name ?? 'Test User' }}</li>
                </ul>
            </div>
            
            <p>If you received this email, your SMTP configuration is working properly! ✅</p>
            
            <div style="text-align: center;">
                <a href="{{ $site_url ?? config('app.url') }}" class="button">
                    Visit {{ $site_name }}
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>{{ $site_name }} Team</strong></p>
            <p><small>This is a test email. Please do not reply.</small></p>
            <p><small>&copy; {{ date('Y') }} {{ $site_name }}. All rights reserved.</small></p>
        </div>
    </div>
</body>
</html>
