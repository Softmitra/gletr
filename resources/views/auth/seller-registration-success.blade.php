@extends('layouts.marketplace')

@section('title', 'Registration Successful - Gletr')
@section('description', 'Your seller registration has been submitted successfully. Please wait for approval.')

@push('styles')
<style>
    .success-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0f9ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        max-width: 600px;
        width: 100%;
        text-align: center;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        70% {
            box-shadow: 0 0 0 20px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .success-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .success-message {
        font-size: 1.125rem;
        color: #6b7280;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .approval-notice {
        background: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
    }

    .approval-notice h3 {
        color: #92400e;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .approval-notice p {
        color: #78350f;
        margin: 0;
    }

    .support-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem 0;
    }

    .support-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
    }

    .contact-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: #f59e0b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .contact-details h4 {
        font-weight: 600;
        color: #374151;
        margin: 0 0 0.25rem 0;
    }

    .contact-details p {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }

    .home-button {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1.125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 1rem;
    }

    .home-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 640px) {
        .success-card {
            padding: 2rem 1.5rem;
        }

        .success-title {
            font-size: 2rem;
        }

        .contact-info {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <span class="material-symbols-outlined" style="font-size: 4rem; color: white;">check_circle</span>
        </div>

        <!-- Success Message -->
        <h3 class="success-title">Registration Successful!</h3>
        <p class="success-message">
            Thank you for joining Gletr as a seller. Your application has been submitted successfully and is now under review.
        </p>

        <!-- Approval Notice -->
        <div class="approval-notice">
            <h3>📋 What happens next?</h3>
            <p>
                Our team will review your application within 2-3 business days. You will receive an email notification once your account is approved and ready to use.
            </p>
        </div>

        <!-- Support Section -->
        <div class="support-section">
            <h3 class="support-title">Need Help or Support?</h3>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">
                Our support team is here to help you with any questions or concerns.
            </p>

            <div class="contact-info">
                <!-- Email Support -->
                <div class="contact-item">
                    <div class="contact-icon">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div class="contact-details">
                        <h4>Email Support</h4>
                        <p>support@gletr.com</p>
                    </div>
                </div>

                <!-- Phone Support -->
                <div class="contact-item">
                    <div class="contact-icon">
                        <span class="material-symbols-outlined">phone</span>
                    </div>
                    <div class="contact-details">
                        <h4>Phone Support</h4>
                        <p>+91 98765 43210</p>
                    </div>
                </div>
            </div>

            <!-- Additional Support Info -->
            <div style="background: #e0f2fe; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                <p style="margin: 0; color: #0c4a6e; font-size: 0.875rem;">
                    <strong>Support Hours:</strong> Monday to Friday, 9:00 AM - 6:00 PM IST<br>
                    <strong>Response Time:</strong> Within 24 hours
                </p>
            </div>
        </div>

        <!-- Home Button -->
        <a href="{{ route('home') }}" class="home-button">
            <span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 0.5rem;">home</span>
            Go to Homepage
        </a>

        <!-- Additional Links -->
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                Want to learn more about selling on Gletr?
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('seller.promotion') }}" style="color: #f59e0b; text-decoration: none; font-weight: 500;">
                    Seller Guidelines
                </a>
                <span style="color: #d1d5db;">•</span>
                <a href="#" style="color: #f59e0b; text-decoration: none; font-weight: 500;">
                    FAQ
                </a>
                <span style="color: #d1d5db;">•</span>
                <a href="#" style="color: #f59e0b; text-decoration: none; font-weight: 500;">
                    Terms & Conditions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
