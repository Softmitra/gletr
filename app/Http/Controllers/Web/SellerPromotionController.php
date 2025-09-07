<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerPromotionController extends Controller
{
    /**
     * Show the seller promotion page
     */
    public function index()
    {
        // Get real statistics for the promotion page
        $stats = [
            'total_sellers' => Seller::where('status', 'active')->count(),
            'total_customers' => 1000000, // You can replace with actual customer count
            'monthly_sales' => 5000000, // You can calculate actual monthly sales
            'seller_satisfaction' => 99.2, // You can calculate from reviews/feedback
        ];

        // Get some success stories/testimonials (you can create a testimonials table later)
        $testimonials = [
            [
                'name' => 'Priya Sharma',
                'location' => 'Mumbai',
                'image' => '/images/sellers/priya-sharma.jpg',
                'review' => 'Gletr has transformed my small jewellery business. I\'ve increased my sales by 300% in just 6 months. The support team is amazing!',
                'rating' => 5,
                'business_growth' => '300%'
            ],
            [
                'name' => 'Rajesh Kumar',
                'location' => 'Delhi',
                'image' => '/images/sellers/rajesh-kumar.jpg',
                'review' => 'The analytics dashboard helps me understand my customers better. I can now make data-driven decisions for my business.',
                'rating' => 5,
                'business_growth' => '250%'
            ],
            [
                'name' => 'Meera Patel',
                'location' => 'Surat',
                'image' => '/images/sellers/meera-patel.jpg',
                'review' => 'From a local shop to nationwide delivery - Gletr made it possible. The logistics support is exceptional!',
                'rating' => 5,
                'business_growth' => '400%'
            ]
        ];

        // Benefits data
        $benefits = [
            [
                'icon' => 'users',
                'color' => 'blue',
                'title' => 'Massive Customer Reach',
                'description' => 'Access to over 1 million active customers across India. Expand your business beyond geographical boundaries.'
            ],
            [
                'icon' => 'percent',
                'color' => 'green',
                'title' => 'Competitive Commission',
                'description' => 'Industry-leading commission rates starting from just 3%. Keep more of your earnings and grow faster.'
            ],
            [
                'icon' => 'truck',
                'color' => 'purple',
                'title' => 'Logistics Support',
                'description' => 'End-to-end logistics support with secure packaging, insurance, and tracking for all your shipments.'
            ],
            [
                'icon' => 'megaphone',
                'color' => 'yellow',
                'title' => 'Marketing Support',
                'description' => 'Professional product photography, SEO optimization, and promotional campaigns to boost your sales.'
            ],
            [
                'icon' => 'headphones',
                'color' => 'red',
                'title' => '24/7 Seller Support',
                'description' => 'Dedicated seller support team available round the clock to help you with any queries or issues.'
            ],
            [
                'icon' => 'trending-up',
                'color' => 'indigo',
                'title' => 'Analytics & Insights',
                'description' => 'Detailed analytics dashboard to track your performance, sales trends, and customer behavior.'
            ],
            [
                'icon' => 'shield-check',
                'color' => 'teal',
                'title' => 'Secure Payments',
                'description' => 'Guaranteed secure and timely payments with multiple payment options and fraud protection.'
            ],
            [
                'icon' => 'award',
                'color' => 'pink',
                'title' => 'Quality Assurance',
                'description' => 'Hallmark verification and quality certification to build customer trust and increase sales.'
            ],
            [
                'icon' => 'smartphone',
                'color' => 'orange',
                'title' => 'Mobile App',
                'description' => 'Manage your business on-the-go with our feature-rich seller mobile app for iOS and Android.'
            ]
        ];

        // Registration process steps
        $registrationSteps = [
            [
                'step' => 1,
                'icon' => 'user-plus',
                'color' => 'blue',
                'title' => 'Basic Registration',
                'items' => [
                    'Personal Information',
                    'Business Details',
                    'Contact Information',
                    'Email Verification'
                ]
            ],
            [
                'step' => 2,
                'icon' => 'file-text',
                'color' => 'green',
                'title' => 'KYC Documents',
                'items' => [
                    'PAN Card',
                    'Aadhaar Card',
                    'GST Certificate',
                    'Business License'
                ]
            ],
            [
                'step' => 3,
                'icon' => 'building',
                'color' => 'purple',
                'title' => 'Bank Verification',
                'items' => [
                    'Bank Account Details',
                    'IFSC Code',
                    'Account Verification',
                    'Payment Setup'
                ]
            ],
            [
                'step' => 4,
                'icon' => 'check-circle',
                'color' => 'yellow',
                'title' => 'Approval & Launch',
                'items' => [
                    'Document Review',
                    'Account Approval',
                    'Seller Dashboard Access',
                    'Start Selling!'
                ]
            ]
        ];

        // FAQ data
        $faqs = [
            [
                'question' => 'How much does it cost to sell on Gletr?',
                'answer' => 'Registration is completely free! We only charge a small commission (starting from 3%) on successful sales. There are no monthly fees, listing fees, or hidden charges. You only pay when you sell.'
            ],
            [
                'question' => 'How long does the registration process take?',
                'answer' => 'The registration process typically takes 24-48 hours after you submit all required documents. Our team reviews your application and documents to ensure quality and authenticity.'
            ],
            [
                'question' => 'What documents do I need to register?',
                'answer' => 'You\'ll need: PAN Card, Aadhaar Card, GST Certificate (if applicable), Business License, Bank Account Details, and Hallmark Certificate for gold/silver jewellery. Our team will guide you through the process.'
            ],
            [
                'question' => 'How do I receive payments?',
                'answer' => 'Payments are transferred directly to your bank account within 7-10 business days after order delivery. We provide detailed payment reports and support multiple payment methods for your customers.'
            ],
            [
                'question' => 'Do you provide marketing support?',
                'answer' => 'Yes! We provide professional product photography, SEO optimization, promotional campaigns, social media marketing, and featured listings to help boost your sales and visibility.'
            ],
            [
                'question' => 'What about shipping and logistics?',
                'answer' => 'We handle all logistics including secure packaging, insurance, tracking, and delivery. Our logistics partners ensure safe delivery of your precious jewellery items across India.'
            ],
            [
                'question' => 'Can I sell both gold and silver jewellery?',
                'answer' => 'Absolutely! You can sell gold, silver, platinum, diamond, and fashion jewellery. We support all types of jewellery with proper hallmark certification and quality assurance.'
            ],
            [
                'question' => 'Is there a minimum order requirement?',
                'answer' => 'No minimum order requirement! You can start with as few products as you want. Many successful sellers started with just 10-20 products and grew their business over time.'
            ]
        ];

        // Support contact information
        $support = [
            'phone' => '+91 9876543210',
            'email' => 'seller-support@gletr.com',
            'whatsapp' => '+91 9876543210',
            'hours' => 'Mon-Sat: 9 AM - 9 PM',
            'response_time' => 'Response within 24 hours'
        ];

        return view('seller.promotion', compact(
            'stats',
            'testimonials',
            'benefits',
            'registrationSteps',
            'faqs',
            'support'
        ));
    }
}
