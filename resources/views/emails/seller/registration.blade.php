<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Welcome to {{ $site_name }} Seller Portal!</title>
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
                        <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px 30px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 28px; font-weight: bold;">🏪 Welcome to {{ $site_name }} Seller Portal!</h1>
                            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Join our thriving marketplace community</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Greeting -->
                            <h2 style="color: #333333; font-size: 24px; margin: 0 0 20px 0;">Dear {{ $seller_name }},</h2>
                            
                            <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 0 0 25px 0;">
                                Thank you for registering as a seller with <strong>{{ $site_name }}</strong>! We're thrilled to welcome <strong>{{ $business_name }}</strong> to our marketplace.
                            </p>
                            
                            <!-- Registration Details Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f0fdf4; border-radius: 8px; margin: 25px 0; border-left: 4px solid #10b981;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #333333; font-size: 20px; margin: 0 0 15px 0;">📋 Registration Received</h3>
                                        <p style="color: #555555; font-size: 16px; margin: 0 0 15px 0;">Your seller registration has been successfully received and is now under review:</p>
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Business Name:</strong> {{ $business_name }}</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Email:</strong> {{ $seller_email }}</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Registration Date:</strong> {{ date('F j, Y') }}</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Next Steps Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #eff6ff; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #333333; font-size: 20px; margin: 0 0 15px 0;">🚀 Next Steps</h3>
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr><td style="padding: 8px 0; color: #555555; font-size: 15px;"><strong>1. Email Verification:</strong> Please verify your email address by clicking the button below</td></tr>
                                            <tr><td style="padding: 8px 0; color: #555555; font-size: 15px;"><strong>2. Document Verification:</strong> Our team will review your submitted documents</td></tr>
                                            <tr><td style="padding: 8px 0; color: #555555; font-size: 15px;"><strong>3. Account Approval:</strong> You'll receive notification once approved</td></tr>
                                        </table>
                                        
                                        <!-- Verification Button -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td align="center" style="padding: 20px 0;">
                                                    <a href="{{ $verification_link }}" style="background-color: #10b981; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;">
                                                        ✅ Verify Email Address
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Timeline Section -->
                            <h3 style="color: #333333; font-size: 20px; margin: 25px 0 15px 0;">⏰ What Happens Next?</h3>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Document Review:</strong> Our verification team will review your documents within 24-48 hours</td></tr>
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Approval Notification:</strong> You'll receive an email once your account is approved</td></tr>
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Dashboard Access:</strong> Start selling immediately after approval</td></tr>
                            </table>
                            
                            <!-- Dashboard Button -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 30px 0 20px 0;">
                                        <a href="{{ $dashboard_url ?? $site_url }}" style="background-color: #059669; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;">
                                            🏪 Access Seller Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Benefits Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #333333; font-size: 20px; margin: 0 0 15px 0;">💼 Benefits of Selling with Us</h3>
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Wide Customer Reach:</strong> Access thousands of jewelry enthusiasts</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Secure Payments:</strong> Safe and reliable payment processing</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Marketing Support:</strong> Promotional tools to boost your sales</td></tr>
                                            <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;">• <strong>Analytics:</strong> Detailed insights into your business performance</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Support Section -->
                            <h3 style="color: #333333; font-size: 20px; margin: 25px 0 15px 0;">📞 Need Support?</h3>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
                                Our seller support team is here to help:
                            </p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Email:</strong> {{ $support_email }}</td></tr>
                                <tr><td style="padding: 5px 0; color: #555555; font-size: 15px;"><strong>Website:</strong> <a href="{{ $site_url }}" style="color: #10b981;">{{ $site_url }}</a></td></tr>
                            </table>
                            
                            <p style="color: #555555; font-size: 16px; line-height: 1.6; margin: 25px 0 0 0;">
                                <strong>Welcome aboard!</strong>
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
                                This is an automated message. Please do not reply to this email.
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
