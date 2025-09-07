<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Welcome to {{ $site_name }}!</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>      
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: Arial, sans-serif;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f4f6f8;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <!-- Main Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 28px; font-weight: bold;">💎 Welcome to {{ $site_name }}!</h1>
                            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Your journey into exquisite jewelry begins here</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Greeting -->
                            <h2 style="color: #333333; font-size: 24px; margin: 0 0 20px 0;">Dear {{ $customer_name }},</h2>
                            
                            <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                Thank you for registering with <strong>{{ $site_name }}</strong>! We're excited to have you as part of our jewelry marketplace community.
                            </p>
                            
                            <!-- Next Steps Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #333333; font-size: 20px; margin: 0 0 15px 0;">🔐 Next Steps</h3>
                                        <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                            To complete your registration, please verify your email address by clicking the button below:
                                        </p>
                                        
                                        <!-- Verification Button -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td align="center" style="padding: 20px 0;">
                                                    <a href="{{ $verification_link }}" style="background-color: #667eea; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;">
                                                        ✅ Verify Email Address
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Features Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f0f9ff; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #333333; font-size: 20px; margin: 0 0 15px 0;">🌟 What's Next?</h3>
                                        <p style="color: #555555; font-size: 16px; margin: 0 0 15px 0;">Once your email is verified, you can:</p>
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• Browse our extensive collection of jewelry</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• Add items to your wishlist</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• Place orders with trusted sellers</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• Track your orders in real-time</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• Leave reviews for products</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Support Section -->
                            <h3 style="color: #333333; font-size: 20px; margin: 25px 0 15px 0;">📞 Need Help?</h3>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                If you have any questions or need assistance, feel free to contact our support team:
                            </p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Email:</strong> {{ $support_email }}</td></tr>
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Website:</strong> <a href="{{ $site_url }}" style="color: #667eea;">{{ $site_url }}</a></td></tr>
                            </table>
                            
                            <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                Thank you for choosing {{ $site_name }}!
                            </p>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center;">
                            <p style="color: #6c757d; font-size: 16px; font-weight: bold; margin: 0 0 10px 0;">
                                Best regards,<br>The {{ $site_name }} Team
                            </p>
                            <hr style="border: none; border-top: 1px solid #e9ecef; margin: 20px 0;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0 0 5px 0;">
                                If you did not create an account, no further action is required.
                            </p>
                            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                                &copy; {{ $current_year ?? date('Y') }} {{ $site_name }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
