@extends('layouts.marketplace')

@section('title', 'Become a Seller - Gletr')
@section('description',
    'Join Gletr as a seller and reach thousands of customers looking for quality jewellery. Start
    selling your authentic jewellery today.')

    @push('styles')
        <style>
            :root {
                --primary: #f59e0b;
                --primary-dark: #d97706;
                --secondary: #6366f1;
                --success: #10b981;
                --danger: #ef4444;
                --warning: #f59e0b;
                --info: #3b82f6;
                --light: #f9fafb;
                --dark: #111827;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .registration-container {
                min-height: 100vh;
                background: linear-gradient(135deg, #fef3c7 0%, #fff 50%, #fef3c7 100%);
                padding: 2rem 0;
            }

            .registration-wrapper {
                max-width: 900px;
                margin: 0 auto;
                padding: 0 1rem;
            }

            .registration-header {
                text-align: center;
                margin-bottom: 3rem;
                animation: fadeInDown 0.6s ease;
            }

            .registration-header h3 {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--dark);
                margin-bottom: 0.5rem;
            }

            .registration-header p {
                font-size: 1.125rem;
                color: #6b7280;
            }

            .progress-tracker {
                width: 100%;
                margin: 20px auto;
                position: relative;
            }

            .progress-steps {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                /* ✅ allows wrapping on small screens */
                gap: 15px;
                position: relative;
            }

            .progress-line {
                position: absolute;
                top: 20px;
                left: 0;
                width: 100%;
                height: 4px;
                background: #e5e7eb;
                z-index: 0;
            }

            .progress-line-fill {
                height: 100%;
                background: #f59e0b;
                transition: width 0.3s ease;
                z-index: 1;
            }

            .progress-step {
                display: flex;
                flex-direction: column;
                align-items: center;
                flex: 1 1 120px;
                /* ✅ responsive sizing */
                min-width: 100px;
                text-align: center;
                z-index: 2;
            }

            .step-circle {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #e5e7eb;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                position: relative;
            }

            .step-circle.active {
                background: #f59e0b;
                color: white;
            }

            .step-circle.completed {
                background: #10b981;
                color: white;
            }

            .step-label {
                font-size: 12px;
                margin-top: 8px;
                color: #374151;
            }

            .step-label.active {
                font-weight: bold;
                color: #111827;
            }

            /* ✅ Mobile responsiveness */
            @media (max-width: 768px) {
                .progress-steps {
                    gap: 20px;
                    justify-content: center;
                }

                .step-label {
                    font-size: 11px;
                }
            }

            @media (max-width: 480px) {
                .progress-step {
                    flex: 1 1 45%;
                    /* 2 steps per row */
                }

                .progress-line {
                    display: none;
                    /* hide line on very small screens */
                }
            }


            /* Form Container */
            .form-container {
                background: white;
                border-radius: 1rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                animation: fadeInUp 0.8s ease;
            }

            .form-header {
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                color: white;
                padding: 1.5rem 2rem;
            }

            .form-header h2 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .form-header p {
                font-size: 0.875rem;
                opacity: 0.9;
            }

            .form-body {
                padding: 2rem;
            }

            .step-content {
                display: none;
                animation: slideIn 0.4s ease;
            }

            .step-content.active {
                display: block;
            }

            /* Form Elements */
            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 0.5rem;
            }

            .form-label .required {
                color: var(--danger);
            }

            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1.5px solid #e5e7eb;
                border-radius: 1rem;
                font-size: 0.875rem;
                transition: all 0.3s ease;
                background: white;
            }

            .form-input:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
                transform: scale(1.02);
                z-index: 1;
                position: relative;
            }

            .form-input.error {
                border-color: var(--danger);
                background: #fef2f2;
            }

            .form-error {
                font-size: 0.75rem;
                color: var(--danger);
                margin-top: 0.25rem;
                display: none;
            }

            .form-error.show {
                display: block;
            }

            .form-success {
                color: var(--success);
                font-size: 0.75rem;
                margin-top: 0.25rem;
                display: none;
            }

            .form-success.show {
                display: block;
            }

            .validation-loader {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
            }

            .validation-loader .spinner {
                width: 16px;
                height: 16px;
                border: 2px solid #e5e7eb;
                border-top: 2px solid var(--primary);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .form-input.valid {
                border-color: var(--success);
                background-color: #f0fdf4;
            }

            .form-input.invalid {
                border-color: var(--danger);
                background-color: #fef2f2;
            }

            .form-input.checking {
                border-color: var(--warning);
                background-color: #fffbeb;
            }

            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            @media (max-width: 640px) {
                .form-row {
                    grid-template-columns: 1fr;
                }
            }

            /* Upload Areas */
            .upload-area {
                border: 2px dashed #e5e7eb;
                border-radius: 1rem;
                padding: 2rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background: #fafafa;
            }

            .upload-area:hover {
                border-color: var(--primary);
                background: #fffbeb;
            }

            .upload-area.has-file {
                border-color: var(--success);
                background: #f0fdf4;
            }

            .upload-area.has-error {
                border-color: #dc2626;
                background: #fef2f2;
            }

            .upload-area.has-error .upload-icon {
                color: #dc2626;
            }

            .upload-icon {
                font-size: 3rem;
                color: #9ca3af;
                margin-bottom: 0.5rem;
            }

            .upload-text {
                font-size: 0.875rem;
                color: #6b7280;
                margin-bottom: 0.25rem;
            }

            .upload-hint {
                font-size: 0.75rem;
                color: #9ca3af;
            }

            .upload-filename {
                font-size: 0.875rem;
                color: var(--success);
                font-weight: 600;
                margin-top: 0.5rem;
            }

            /* Navigation Buttons */
            .form-navigation {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem 2rem;
                background: #f9fafb;
                border-top: 1px solid #e5e7eb;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 1rem;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                border: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary {
                background: var(--primary);
                color: white;
            }

            .btn-primary:hover {
                background: var(--primary-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            }

            .btn-secondary {
                background: white;
                color: #6b7280;
                border: 1px solid #e5e7eb;
            }

            .btn-secondary:hover {
                background: #f9fafb;
                border-color: #d1d5db;
            }

            .btn-success {
                background: var(--success);
                color: white;
            }

            .btn-success:hover {
                background: #059669;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            }

            /* Review Section */
            .review-section {
                background: #f9fafb;
                border-radius: 1rem;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .review-title {
                font-size: 1rem;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .review-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .review-item {
                font-size: 0.875rem;
            }

            .review-label {
                color: #6b7280;
                margin-bottom: 0.25rem;
            }

            .review-value {
                color: var(--dark);
                font-weight: 600;
            }

            .confirmation-section {
                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                border: 1px solid #f59e0b;
                border-radius: 12px;
                padding: 24px;
                margin: 24px 0;
            }

            .confirmation-title {
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 18px;
                font-weight: 600;
                color: var(--stone-800);
                margin-bottom: 16px;
            }

            .confirmation-content {
                color: var(--stone-700);
            }

            .confirmation-content p {
                margin-bottom: 12px;
                font-weight: 500;
            }

            .confirmation-content ul {
                list-style: none;
                padding: 0;
                margin: 16px 0;
            }

            .confirmation-content li {
                position: relative;
                padding-left: 24px;
                margin-bottom: 8px;
                line-height: 1.5;
            }

            .confirmation-content li:before {
                content: "•";
                position: absolute;
                left: 0;
                color: #f59e0b;
                font-weight: bold;
                font-size: 18px;
            }

            .confirmation-checkbox {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                margin-top: 20px;
                padding: 16px;
                background: rgba(255, 255, 255, 0.7);
                border-radius: 8px;
                border: 1px solid #fbbf24;
            }

            .confirmation-checkbox input[type="checkbox"] {
                margin-top: 2px;
                width: 18px;
                height: 18px;
                accent-color: #f59e0b;
            }

            .confirmation-checkbox label {
                font-weight: 500;
                color: var(--stone-800);
                line-height: 1.4;
                cursor: pointer;
            }

            .document-review-item {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px;
                margin-bottom: 8px;
            }

            .document-review-item.uploaded {
                background: #f0fdf4;
                border-color: #86efac;
            }

            .document-review-item.missing {
                background: #fef2f2;
                border-color: #fca5a5;
            }

            .document-status {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                font-weight: 500;
                padding: 4px 8px;
                border-radius: 4px;
            }

            .document-status.uploaded {
                background: #dcfce7;
                color: #166534;
            }

            .document-status.missing {
                background: #fee2e2;
                color: #991b1b;
            }

            /* Terms Checkbox */
            .terms-container {
                background: #fef3c7;
                border: 1px solid #fbbf24;
                border-radius: 1rem;
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .terms-checkbox {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .terms-checkbox input[type="checkbox"] {
                margin-top: 0.125rem;
                width: 1.25rem;
                height: 1.25rem;
                cursor: pointer;
            }

            .terms-text {
                font-size: 0.875rem;
                color: var(--dark);
                line-height: 1.5;
            }

            .terms-text a {
                color: var(--primary-dark);
                font-weight: 600;
                text-decoration: underline;
            }

            /* Animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Input with Icons */
            .input-with-icon {
                /* position: relative; */
                position: relative;
                display: flex;
                align-items: flex-start;
                /* align items at the top */
            }

            .input-icon {
                position: absolute;
                left: 12px;
                /* top: 50%; */
                /* transform: translateY(-50%); */
                top: 0.5rem;
                /* adjust this to match the first line */
                color: #6b7280;
                z-index: 10;
                pointer-events: none;
                height: 1em;
                display: flex;
            }

            .input-with-icon .form-input {
                padding-left: 3rem;
            }

            .input-with-icon textarea.form-input {
                /* padding-top: 0.75rem;
                                                                                                                                                                padding-left: 3rem; */
                padding-left: 3rem;
                /* space for icon */
                line-height: 1.5;
            }

            /* Password Input Wrapper */
            .password-input-wrapper {
                position: relative;
            }

            .password-toggle {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: #6b7280;
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                transition: all 0.3s ease;
                z-index: 10;
            }

            .password-toggle:hover {
                color: var(--primary);
                background: rgba(99, 102, 241, 0.1);
            }

            .password-toggle:focus {
                outline: none;
                color: var(--primary);
            }

            /* Loading Spinner */
            .spinner {
                display: none;
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid var(--primary);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            .spinner.show {
                display: inline-block;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Success Message */
            .success-message {
                background: var(--success);
                color: white;
                padding: 1rem;
                border-radius: 1rem;
                margin-bottom: 1rem;
                display: none;
                align-items: center;
                gap: 0.5rem;
            }

            .success-message.show {
                display: flex;
            }

            /* Document Upload Styling */
            .document-section {
                margin-bottom: 2rem;
            }

            .document-section h3 {
                color: var(--dark);
                font-size: 1.125rem;
                font-weight: 600;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid #e5e7eb;
            }

            .document-section {
                margin-bottom: 2rem;
            }

            .document-section-title {
                font-size: 1.125rem;
                font-weight: 600;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid #e5e7eb;
                color: var(--dark);
            }

            .document-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
            }

            /* Pincode Loader */
            .pincode-loader {
                position: absolute;
                right: 3rem;
                top: 50%;
                transform: translateY(-50%);
            }

            .spinner {
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid var(--primary);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .pincode-info {
                background: #f0fdf4;
                padding: 0.5rem;
                border-radius: 0.5rem;
                border: 1px solid #bbf7d0;
            }

            @media (max-width: 768px) {
                .document-grid {
                    grid-template-columns: 1fr;
                }
            }

            /* Real-time validation styles */
            .form-input.border-red-500 {
                border-color: #ef4444 !important;
                box-shadow: 0 0 0 1px #ef4444;
            }

            .form-input.border-red-500:focus {
                border-color: #dc2626 !important;
                box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
            }

            .form-error {
                font-size: 0.875rem;
                margin-top: 0.25rem;
                transition: all 0.3s ease;
            }

            .form-error.text-red-500 {
                color: #ef4444;
            }

            /* Success state for valid fields */
            .form-input.border-green-500 {
                border-color: #10b981 !important;
                box-shadow: 0 0 0 1px #10b981;
            }

            .form-input.border-green-500:focus {
                border-color: #059669 !important;
                box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
            }

            /* Validation animation */
            .form-input {
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }
        </style>
    @endpush

@section('content')
    <div class="registration-container">
        <div class="registration-wrapper">
            <!-- Header -->
            <div class="registration-header">
                <h3>Become a Gletr Seller</h3>
                <p>Join thousands of successful sellers on our platform</p>
            </div>

            <!-- Progress Tracker -->
            <div class="progress-tracker">
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-fill" id="progressFill" style="width: 0%"></div>
                    </div>

                    <div class="progress-step">
                        <div class="step-circle active" data-step="1">
                            <span class="step-number">1</span>
                            <span class="step-check" style="display: none;">✓</span>
                        </div>
                        <div class="step-label active">Login Details</div>
                    </div>

                    <div class="progress-step">
                        <div class="step-circle" data-step="2">
                            <span class="step-number">2</span>
                            <span class="step-check" style="display: none;">✓</span>
                        </div>
                        <div class="step-label">Personal Info</div>
                    </div>

                    <div class="progress-step">
                        <div class="step-circle" data-step="3">
                            <span class="step-number">3</span>
                            <span class="step-check" style="display: none;">✓</span>
                        </div>
                        <div class="step-label">Store Setup</div>
                    </div>

                    <div class="progress-step">
                        <div class="step-circle" data-step="4">
                            <span class="step-number">4</span>
                            <span class="step-check" style="display: none;">✓</span>
                        </div>
                        <div class="step-label">Bank Details</div>
                    </div>

                    <div class="progress-step">
                        <div class="step-circle" data-step="5">
                            <span class="step-number">5</span>
                            <span class="step-check" style="display: none;">✓</span>
                        </div>
                        <div class="step-label">Documents</div>
                    </div>

                    <div class="progress-step">
                        <div class="step-circle" data-step="6">
                            <span class="step-number">6</span>
                            <span class="step-check" style="display: none;">✓</span>
                        </div>
                        <div class="step-label">Review</div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <!-- Display Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger"
                        style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h4 style="margin: 0 0 0.5rem 0; font-weight: 600;">Registration Error</h4>
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Display Success Message -->
                @if (session('success'))
                    <div class="alert alert-success"
                        style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h4 style="margin: 0 0 0.5rem 0; font-weight: 600;">Success!</h4>
                        <p style="margin: 0;">{{ session('success') }}</p>
                    </div>
                @endif

                <form id="sellerRegistrationForm" method="POST" action="{{ route('seller.register') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Login Details -->
                    <div class="step-content active" data-step="1">
                        <div class="form-header text-center">
                            <h2>Create Your Account</h2>
                            <p>Set up your login credentials to get started</p>
                        </div>

                        <div class="form-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Email Address <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">mail</span>
                                        </span>
                                        <input type="email" name="email" id="email" class="form-input pl-12"
                                            placeholder="john@example.com" value="{{ old('email') }}" required>
                                        <div class="validation-loader" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>
                                    <div class="form-error" id="email-error">Please enter a valid email address</div>
                                    <div class="form-success" id="email-success" style="display: none;">Email is available
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Phone Number <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">phone</span>
                                        </span>
                                        <input type="tel" name="phone" class="form-input pl-12"
                                            placeholder="+91 98765 43210" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="form-error">Please enter a valid phone number</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Password <span class="required">*</span></label>
                                    <div class="password-input-wrapper">
                                        <input type="password" name="password" id="password" class="form-input pr-12"
                                            placeholder="Min. 8 characters" required>
                                        <button type="button" class="password-toggle"
                                            onclick="togglePassword('password')">
                                            <span class="material-symbols-outlined">visibility_off</span>
                                        </button>
                                    </div>
                                    <div class="form-error">Password must be at least 8 characters</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Confirm Password <span class="required">*</span></label>
                                    <div class="password-input-wrapper">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-input pr-12" placeholder="Re-enter password" required>
                                        <button type="button" class="password-toggle"
                                            onclick="togglePassword('password_confirmation')">
                                            <span class="material-symbols-outlined">visibility_off</span>
                                        </button>
                                    </div>
                                    <div class="form-error">Passwords do not match</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Personal Information -->
                    <div class="step-content" data-step="2">
                        <div class="form-header text-center">
                            <h2>Personal Information</h2>
                            <p>Tell us about yourself and your business</p>
                        </div>

                        <div class="form-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Full Name <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">person</span>
                                        </span>
                                        <input type="text" name="name" class="form-input pl-12"
                                            placeholder="John Doe" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-error">Please enter your full name</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Phone Number <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">phone</span>
                                        </span>
                                        <input type="tel" name="phone" id="phone" class="form-input pl-12"
                                            placeholder="9876543210" value="{{ old('phone') }}" maxlength="10"
                                            pattern="[6-9][0-9]{9}" required>
                                        <div class="validation-loader" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>
                                    <div class="form-error" id="phone-error">Please enter a valid 10-digit mobile number
                                        starting with 6, 7, 8, or 9</div>
                                    <div class="form-success" id="phone-success" style="display: none;">Phone number is
                                        available</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Business Type <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">business</span>
                                        </span>
                                        <select name="seller_type_id" class="form-input pl-12" required>
                                            <option value="">Select Business Type</option>
                                            @foreach ($sellerTypes as $sellerType)
                                                <option value="{{ $sellerType->id }}"
                                                    {{ old('seller_type_id') == $sellerType->id ? 'selected' : '' }}>
                                                    {{ $sellerType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-error">Please select a business type</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Pincode <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">pin_drop</span>
                                        </span>
                                        <input type="text" name="pincode" id="pincode" class="form-input pl-12"
                                            placeholder="110001" maxlength="6" value="{{ old('pincode') }}" required>
                                        <div class="pincode-loader" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>
                                    <div class="form-error">Please enter a valid pincode</div>
                                    <div class="pincode-info"
                                        style="display: none; margin-top: 0.5rem; font-size: 0.75rem; color: #059669;">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Complete Address <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="input-icon">
                                        <span class="material-symbols-outlined">home</span>
                                    </span>
                                    <textarea name="address" class="form-input pl-12" rows="3"
                                        placeholder="House/Flat No., Building, Street, Locality" required>{{ old('address') }}</textarea>
                                </div>
                                <div class="form-error">Please enter your address</div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Area/Locality <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">location_on</span>
                                        </span>
                                        <select name="area" id="area" class="form-input pl-12" required>
                                            <option value="">Select Area</option>
                                        </select>
                                    </div>
                                    <div class="form-error">Please select your area</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">City <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">location_city</span>
                                        </span>
                                        <input type="text" name="city" id="city" class="form-input pl-12"
                                            placeholder="City" value="{{ old('city') }}" readonly required>
                                    </div>
                                    <div class="form-error">Please enter your city</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">State <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">map</span>
                                        </span>
                                        <input type="text" name="state" id="state" class="form-input pl-12"
                                            placeholder="State" value="{{ old('state') }}" readonly required>
                                    </div>
                                    <div class="form-error">Please enter your state</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Country <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">public</span>
                                        </span>
                                        <input type="text" name="country" id="country" class="form-input pl-12"
                                            value="India" readonly required>
                                    </div>
                                    <div class="form-error">Please enter a valid pincode</div>
                                </div>
                            </div>

                            {{-- New Start --}}
                            <div class="form-group">
                                <label class="form-label">Profile Image</label>
                                <div class="upload-area" onclick="document.getElementById('seller_image').click()">
                                    <div class="upload-icon">👤</div>
                                    <div class="image-preview-container"></div>

                                    <div class="upload-text">Click to upload your profile photo</div>
                                    <div class="upload-hint">JPG, PNG (Max 2MB)</div>
                                    <div class="upload-filename"></div>
                                    <div class="form-error"
                                        style="color: #dc2626; font-size: 13px; margin-top: 5px; display: none;"></div>
                                </div>
                                <input type="file" id="seller_image" name="seller_image" accept=".jpg,.jpeg,.png"
                                    style="display: none;">
                            </div>

                            <script>
                                document.getElementById('seller_image').addEventListener('change', function() {
                                    const file = this.files[0];
                                    const uploadArea = this.closest('.form-group').querySelector('.upload-area');
                                    const filenameElement = uploadArea.querySelector('.upload-filename');
                                    const previewContainer = uploadArea.querySelector('.image-preview-container');
                                    const uploadIcon = uploadArea.querySelector('.upload-icon');
                                    const errorElement = uploadArea.querySelector('.form-error');

                                    // Clear previous data
                                    filenameElement.textContent = '';
                                    previewContainer.innerHTML = '';
                                    errorElement.style.display = 'none';
                                    uploadIcon.style.display = 'block';

                                    if (file) {
                                        const validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];
                                        const maxSize = 2 * 1024 * 1024; // 2MB in bytes

                                        // ✅ Extension check
                                        if (!validExtensions.includes(file.type)) {
                                            errorElement.textContent = '❌ Please select a valid JPG or PNG image';
                                            errorElement.style.display = 'block';
                                            this.value = ''; // reset file input
                                            return;
                                        }

                                        // ✅ Size check
                                        if (file.size > maxSize) {
                                            errorElement.textContent = '❌ The image must not be greater than 2MB';
                                            errorElement.style.display = 'block';
                                            this.value = ''; // reset file input
                                            return;
                                        }

                                        filenameElement.textContent = file.name;

                                        // ✅ Show preview
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.className = 'preview-img';
                                            img.style.width = '100px';
                                            img.style.height = '150px';
                                            img.style.objectFit = 'cover';

                                            // Hide 👤 icon
                                            uploadIcon.style.display = 'none';

                                            // ✅ Center image
                                            const wrapper = document.createElement('div');
                                            wrapper.style.display = 'flex';
                                            wrapper.style.justifyContent = 'center';
                                            wrapper.style.alignItems = 'center';
                                            wrapper.style.width = '100%';
                                            wrapper.style.marginTop = '10px';

                                            wrapper.appendChild(img);
                                            previewContainer.appendChild(wrapper);
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>

                            {{-- New End --}}
                        </div>
                    </div>

                    <!-- Step 3: Store Details -->
                    <div class="step-content" data-step="3">
                        <div class="form-header text-center">
                            <h2>Store Setup</h2>
                            <p>Configure your store details and branding</p>
                        </div>

                        <div class="form-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Store Name <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">store</span>
                                        </span>
                                        <input type="text" name="business_name" class="form-input pl-12"
                                            placeholder="My Jewelry Store" value="{{ old('business_name') }}" required>
                                    </div>
                                    <div class="form-error">Please enter your store name</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Store Address <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="input-icon">
                                        <span class="material-symbols-outlined">location_on</span>
                                    </span>
                                    <textarea name="store_address" class="form-input pl-12" rows="3" placeholder="Enter your store address"
                                        required></textarea>
                                </div>
                                <div class="form-error">Please enter your store address</div>
                            </div>

                            {{-- New Start --}}
                            <!-- Store Logo -->
                            <!-- Store Logo -->
                            <div class="form-group">
                                <label class="form-label">Store Logo <span class="required">*</span></label>
                                <div class="upload-area" onclick="document.getElementById('store_logo').click()">
                                    <div class="upload-icon">🏪</div>
                                    <div class="image-preview-container"></div>
                                    <div class="upload-text">Upload Store Logo</div>
                                    <div class="upload-hint">1:1 ratio, Max 2MB (JPG, PNG)</div>
                                    <div class="upload-filename"></div>
                                    <div class="form-error"
                                        style="color:#dc2626;font-size:13px;margin-top:5px;display:none;"></div>
                                </div>
                                <input type="file" id="store_logo" name="store_logo" accept=".jpg,.jpeg,.png"
                                    style="display:none;" required>
                            </div>

                            <!-- Store Banner -->
                            <div class="form-group">
                                <label class="form-label">Store Banner <span class="required">*</span></label>
                                <div class="upload-area" onclick="document.getElementById('store_banner').click()">
                                    <div class="upload-icon">🖼️</div>
                                    <div class="image-preview-container"></div>
                                    <div class="upload-text">Upload Store Banner</div>
                                    <div class="upload-hint">2:1 ratio, Max 2MB (JPG, PNG)</div>
                                    <div class="upload-filename"></div>
                                    <div class="form-error"
                                        style="color:#dc2626;font-size:13px;margin-top:5px;display:none;"></div>
                                </div>
                                <input type="file" id="store_banner" name="store_banner" accept=".jpg,.jpeg,.png"
                                    style="display:none;" required>
                            </div>

                            <script>
                                function setupImagePreview(inputId, maxWidth, maxHeight) {
                                    document.getElementById(inputId).addEventListener('change', function() {
                                        const file = this.files[0];
                                        const uploadArea = this.closest('.form-group').querySelector('.upload-area');
                                        const filenameElement = uploadArea.querySelector('.upload-filename');
                                        const previewContainer = uploadArea.querySelector('.image-preview-container');
                                        const uploadIcon = uploadArea.querySelector('.upload-icon');
                                        const errorElement = uploadArea.querySelector('.form-error');

                                        // Reset
                                        filenameElement.textContent = '';
                                        previewContainer.innerHTML = '';
                                        errorElement.style.display = 'none';
                                        uploadIcon.style.display = 'block';

                                        if (file) {
                                            const validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];
                                            const maxSize = 2 * 1024 * 1024; // 2MB in bytes

                                            // ✅ Type check
                                            if (!validExtensions.includes(file.type)) {
                                                errorElement.textContent = '❌ Please select a valid JPG or PNG image';
                                                errorElement.style.display = 'block';
                                                this.value = ''; // reset input
                                                return;
                                            }

                                            // ✅ Size check
                                            if (file.size > maxSize) {
                                                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                                                errorElement.textContent = `❌ The image size is ${sizeInMB} MB. Max allowed is 2 MB.`;
                                                errorElement.style.display = 'block';
                                                this.value = ''; // reset input
                                                return;
                                            }

                                            filenameElement.textContent = file.name;

                                            // ✅ Preview
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                const img = document.createElement('img');
                                                img.src = e.target.result;
                                                img.className = 'preview-img';
                                                img.style.maxWidth = maxWidth + 'px';
                                                img.style.maxHeight = maxHeight + 'px';
                                                img.style.objectFit = 'cover';
                                                img.style.marginTop = '10px';

                                                // Hide icon
                                                uploadIcon.style.display = 'none';

                                                // Center wrapper
                                                const wrapper = document.createElement('div');
                                                wrapper.style.display = 'flex';
                                                wrapper.style.justifyContent = 'center';
                                                wrapper.style.alignItems = 'center';
                                                wrapper.style.width = '100%';

                                                wrapper.appendChild(img);
                                                previewContainer.appendChild(wrapper);
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    });
                                }

                                // ✅ Initialize previews
                                setupImagePreview('store_logo', 120, 120); // Store Logo (1:1)
                                setupImagePreview('store_banner', 300, 150); // Store Banner (2:1)
                            </script>


                            {{-- New End --}}

                        </div>
                    </div>

                    <!-- Step 4: Bank Details -->
                    <div class="step-content" data-step="4">
                        <div class="form-header text-center">
                            <h2>Banking Information</h2>
                            <p>Add your bank account details for payments</p>
                        </div>

                        <div class="form-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Bank Name <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">account_balance</span>
                                        </span>
                                        <input type="text" name="bank_name" class="form-input pl-12"
                                            placeholder="State Bank of India" value="{{ old('bank_name') }}" required>
                                    </div>
                                    <div class="form-error">Please enter bank name</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Account Holder Name <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">person</span>
                                        </span>
                                        <input type="text" name="holder_name" class="form-input pl-12"
                                            placeholder="John Doe" value="{{ old('holder_name') }}" required>
                                    </div>
                                    <div class="form-error">Please enter account holder name</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Account Number <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">credit_card</span>
                                        </span>
                                        <input type="text" name="account_no" class="form-input pl-12"
                                            placeholder="1234567890" value="{{ old('account_no') }}" required>
                                    </div>
                                    <div class="form-error">Please enter account number</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">IFSC Code <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">code</span>
                                        </span>
                                        <input type="text" name="ifsc_code" class="form-input pl-12"
                                            placeholder="SBIN0001234" value="{{ old('ifsc_code') }}" required>
                                    </div>
                                    <div class="form-error">Please enter IFSC code</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Branch Name</label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">account_tree</span>
                                        </span>
                                        <input type="text" name="branch" class="form-input pl-12"
                                            placeholder="Main Branch" value="{{ old('branch') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">PAN Number <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <span class="input-icon">
                                            <span class="material-symbols-outlined">description</span>
                                        </span>
                                        <input type="text" name="pan_number" id="pan_number" class="form-input pl-12"
                                            placeholder="ABCDE1234F" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                                            style="text-transform: uppercase;" value="{{ old('pan_number') }}" required>
                                        <div class="validation-loader" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>
                                    <div class="form-error" id="pan-error">Please enter a valid PAN number format (e.g.,
                                        ABCDE1234F)</div>
                                    <div class="form-success" id="pan-success" style="display: none;">PAN number is
                                        available</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">GST Number <span class="text-gray-500">(Optional)</span></label>
                                <div class="input-with-icon">
                                    <span class="input-icon">
                                        <span class="material-symbols-outlined">receipt</span>
                                    </span>
                                    <input type="text" name="gst_number" id="gst_number" class="form-input pl-12"
                                        placeholder="22ABCDE1234F1Z5" maxlength="15"
                                        pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}"
                                        style="text-transform: uppercase;" value="{{ old('gst_number') }}">
                                    <div class="validation-loader" style="display: none;">
                                        <div class="spinner"></div>
                                    </div>
                                </div>
                                <div class="form-error" id="gst-error" style="display: none;">Please enter a valid GST
                                    number format (e.g., 22ABCDE1234F1Z5)</div>
                                <div class="form-success" id="gst-success" style="display: none;">GST number is available
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Documents -->
                    <div class="step-content" data-step="5">
                        <div class="form-header text-center">
                            <h2>Document Upload</h2>
                            <p>Upload required documents for verification</p>
                        </div>

                        <div class="form-body">
                            <div id="documentUploadContainer">
                                <div class="text-center text-gray-500 py-8">
                                    <div class="text-2xl mb-2">📋</div>
                                    <p>Please select a business type first to see required documents</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Review -->
                    <div class="step-content" data-step="6">
                        <div class="form-header text-center">
                            <h2>Review & Submit</h2>
                            <p>Please review your information before submitting</p>
                        </div>

                        <div class="form-body">
                            <div class="success-message" id="successMessage">
                                <span>✓</span>
                                <span>All information verified successfully!</span>
                            </div>

                            <!-- Personal Information Section -->
                            <div class="review-section">
                                <div class="review-title">
                                    <span>👤</span>
                                    <span>Personal Information</span>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item">
                                        <div class="review-label">Full Name</div>
                                        <div class="review-value" id="review-name">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Email Address</div>
                                        <div class="review-value" id="review-email">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Phone Number</div>
                                        <div class="review-value" id="review-phone">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Business Type</div>
                                        <div class="review-value" id="review-business-type">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Pincode</div>
                                        <div class="review-value" id="review-pincode">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Address</div>
                                        <div class="review-value" id="review-address">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Area</div>
                                        <div class="review-value" id="review-area">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">City</div>
                                        <div class="review-value" id="review-city">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">State</div>
                                        <div class="review-value" id="review-state">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Country</div>
                                        <div class="review-value" id="review-country">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Store Information Section -->
                            <div class="review-section">
                                <div class="review-title">
                                    <span>🏪</span>
                                    <span>Store Information</span>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item">
                                        <div class="review-label">Business Name</div>
                                        <div class="review-value" id="review-business-name">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Store Address</div>
                                        <div class="review-value" id="review-store-address">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Information Section -->
                            <div class="review-section">
                                <div class="review-title">
                                    <span>🏦</span>
                                    <span>Bank Information</span>
                                </div>
                                <div class="review-grid">
                                    <div class="review-item">
                                        <div class="review-label">Bank Name</div>
                                        <div class="review-value" id="review-bank-name">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Account Holder Name</div>
                                        <div class="review-value" id="review-holder-name">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Account Number</div>
                                        <div class="review-value" id="review-account-no">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">IFSC Code</div>
                                        <div class="review-value" id="review-ifsc-code">-</div>
                                    </div>
                                    <div class="review-item">
                                        <div class="review-label">Branch</div>
                                        <div class="review-value" id="review-branch">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents Section -->
                            <div class="review-section">
                                <div class="review-title">
                                    <span>📄</span>
                                    <span>Uploaded Documents</span>
                                </div>
                                <div class="review-grid" id="review-documents">
                                    <div class="review-item">
                                        <div class="review-label">Documents</div>
                                        <div class="review-value">No documents uploaded yet</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirmation Section -->
                            <div class="confirmation-section">
                                <div class="confirmation-title">
                                    <span>⚠️</span>
                                    <span>Important Notice</span>
                                </div>
                                <div class="confirmation-content">
                                    <p>Please carefully review all the information above. Once you submit:</p>
                                    <ul>
                                        <li>Your application will be reviewed by our team</li>
                                        <li>You'll receive an email confirmation</li>
                                        <li>Document verification may take 2-3 business days</li>
                                        <li>You'll be notified once your account is approved</li>
                                    </ul>
                                    <div class="confirmation-checkbox">
                                        <input type="checkbox" id="confirmation_accepted" name="confirmation_accepted"
                                            required>
                                        <label for="confirmation_accepted">
                                            I confirm that all information provided is accurate and complete
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="terms-container">
                                <div class="terms-checkbox">
                                    <input type="checkbox" id="terms_accepted" name="terms_accepted" required>
                                    <label for="terms_accepted" class="terms-text">
                                        I agree to the <a href="#">Terms and Conditions</a>,
                                        <a href="#">Seller Agreement</a>, and
                                        <a href="#">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                            <span>←</span>
                            <span>Previous</span>
                        </button>

                        <div></div>

                        <button type="button" class="btn btn-primary" id="nextBtn">
                            <span>Next</span>
                            <span>→</span>
                        </button>

                        <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                            <span>Complete Registration</span>
                            <div class="spinner" id="submitSpinner"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Real-time validation functions
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validatePhone(phone) {
            const phoneRegex = /^[6-9]\d{9}$/;
            const cleanPhone = phone.replace(/\D/g, '');
            return phoneRegex.test(cleanPhone);
        }

        function validatePAN(pan) {
            const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            return panRegex.test(pan.toUpperCase());
        }

        function validateGST(gst) {
            if (!gst) return true; // GST is optional
            const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
            return gstRegex.test(gst.toUpperCase());
        }

        // AJAX validation functions
        function checkEmailAvailability(email) {
            return new Promise((resolve, reject) => {
                if (!validateEmail(email)) {
                    resolve({
                        available: false,
                        message: 'Please enter a valid email address'
                    });
                    return;
                }

                fetch('{{ route('seller.check-email') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.json())
                    .then(data => resolve(data))
                    .catch(error => reject(error));
            });
        }


        function checkPANAvailability(pan) {
            return new Promise((resolve, reject) => {
                const upperPAN = pan.toUpperCase();

                if (!validatePAN(upperPAN)) {
                    resolve({
                        available: false,
                        message: 'Please enter a valid PAN number format (e.g., ABCDE1234F)'
                    });
                    return;
                }

                fetch('{{ route('seller.check-pan') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            pan_number: upperPAN
                        })
                    })
                    .then(response => response.json())
                    .then(data => resolve(data))
                    .catch(error => reject(error));
            });
        }

        function checkGSTAvailability(gst) {
            return new Promise((resolve, reject) => {
                if (!gst) {
                    resolve({
                        available: true,
                        message: 'GST number is optional'
                    });
                    return;
                }

                const upperGST = gst.toUpperCase();

                if (!validateGST(upperGST)) {
                    resolve({
                        available: false,
                        message: 'Please enter a valid GST number format (e.g., 22ABCDE1234F1Z5)'
                    });
                    return;
                }

                fetch('{{ route('seller.check-gst') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            gst_number: upperGST
                        })
                    })
                    .then(response => response.json())
                    .then(data => resolve(data))
                    .catch(error => reject(error));
            });
        }

        // UI helper functions
        function showValidationState(fieldId, state, message) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById(fieldId + '-error');
            const successElement = document.getElementById(fieldId + '-success');
            const loader = field.parentElement.querySelector('.validation-loader');

            // Reset classes
            field.classList.remove('valid', 'invalid', 'checking');

            // Hide loader
            if (loader) loader.style.display = 'none';

            // Hide all messages
            if (errorElement) {
                errorElement.style.display = 'none';
                errorElement.classList.remove('show');
            }
            if (successElement) {
                successElement.style.display = 'none';
                successElement.classList.remove('show');
            }

            // Apply new state
            if (state === 'checking') {
                field.classList.add('checking');
                if (loader) loader.style.display = 'block';
            } else if (state === 'valid') {
                field.classList.add('valid');
                if (successElement) {
                    successElement.textContent = message;
                    successElement.style.display = 'block';
                    successElement.classList.add('show');
                }
            } else if (state === 'invalid') {
                field.classList.add('invalid');
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                    errorElement.classList.add('show');
                }
            }
        }

        function validateIFSC(ifsc) {
            const ifscRegex = /^[A-Z]{4}0[A-Z0-9]{6}$/;
            return ifsc.length === 11 && ifscRegex.test(ifsc.toUpperCase());
        }

        function validatePincode(pincode) {
            const pincodeRegex = /^\d{6}$/;
            return pincodeRegex.test(pincode);
        }

        function showFieldError(field, message) {
            const formGroup = field.closest('.form-group');
            const errorDiv = formGroup.querySelector('.form-error');

            // Add error styling
            field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            field.classList.remove('border-stone-300', 'focus:border-stone-500', 'focus:ring-stone-500');

            // Show error message
            if (errorDiv) {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
                errorDiv.classList.add('text-red-500');
            }

            // Focus on field
            field.focus();

            // Scroll to field
            field.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function clearFieldError(field) {
            const formGroup = field.closest('.form-group');
            const errorDiv = formGroup.querySelector('.form-error');

            // Remove error styling
            field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            field.classList.add('border-stone-300', 'focus:border-stone-500', 'focus:ring-stone-500');

            // Hide error message
            if (errorDiv) {
                errorDiv.style.display = 'none';
                errorDiv.classList.remove('text-red-500');
            }
        }

        function showFieldSuccess(field) {
            const formGroup = field.closest('.form-group');

            // Add success styling
            field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            field.classList.add('border-green-500', 'focus:border-green-500', 'focus:ring-green-500');

            // Hide any error messages
            const errorDiv = formGroup.querySelector('.form-error');
            if (errorDiv) {
                errorDiv.style.display = 'none';
                errorDiv.classList.remove('text-red-500');
            }
        }

        function attachRealTimeValidation() {
            // Email validation
            const emailField = document.querySelector('input[name="email"]');
            if (emailField) {
                emailField.addEventListener('blur', function() {
                    const email = this.value.trim();
                    if (email && !validateEmail(email)) {
                        showFieldError(this, 'Please enter a valid email address');
                    } else if (email) {
                        clearFieldError(this);
                    }
                });

                emailField.addEventListener('input', function() {
                    if (this.value.trim() && validateEmail(this.value.trim())) {
                        showFieldSuccess(this);
                    }
                });
            }

            // Phone validation
            const phoneField = document.querySelector('input[name="phone"]');
            if (phoneField) {
                phoneField.addEventListener('blur', function() {
                    const phone = this.value.trim();
                    if (phone && !validatePhone(phone)) {
                        showFieldError(this, 'Please enter a valid 10-digit mobile number starting with 6-9');
                    } else if (phone) {
                        clearFieldError(this);
                    }
                });

                phoneField.addEventListener('input', function() {
                    // Allow only numbers and limit to 10 digits
                    this.value = this.value.replace(/\D/g, '').substring(0, 10);

                    if (this.value.length === 10 && validatePhone(this.value)) {
                        showFieldSuccess(this);
                    }
                });
            }

            // IFSC validation
            const ifscField = document.querySelector('input[name="ifsc_code"]');
            if (ifscField) {
                ifscField.addEventListener('blur', function() {
                    const ifsc = this.value.trim().toUpperCase();
                    if (ifsc && !validateIFSC(ifsc)) {
                        showFieldError(this, 'IFSC code must be exactly 11 characters (e.g., SBIN0001234)');
                    } else if (ifsc) {
                        clearFieldError(this);
                    }
                });

                ifscField.addEventListener('input', function() {
                    // Convert to uppercase and limit to 11 characters
                    this.value = this.value.toUpperCase().substring(0, 11);

                    if (this.value.length === 11 && validateIFSC(this.value)) {
                        showFieldSuccess(this);
                    }
                });
            }

            // Pincode validation
            const pincodeField = document.querySelector('input[name="pincode"]');
            if (pincodeField) {
                pincodeField.addEventListener('blur', function() {
                    const pincode = this.value.trim();
                    if (pincode && !validatePincode(pincode)) {
                        showFieldError(this, 'Please enter a valid 6-digit pincode');
                    } else if (pincode) {
                        clearFieldError(this);
                    }
                });

                pincodeField.addEventListener('input', function() {
                    // Allow only numbers and limit to 6 digits
                    this.value = this.value.replace(/\D/g, '').substring(0, 6);

                    if (this.value.length === 6 && validatePincode(this.value)) {
                        showFieldSuccess(this);
                    }
                });
            }

            // Account number validation
            const accountField = document.querySelector('input[name="account_no"]');
            if (accountField) {
                accountField.addEventListener('blur', function() {
                    const account = this.value.trim();
                    if (account && (account.length < 9 || account.length > 18)) {
                        showFieldError(this, 'Account number must be between 9-18 digits');
                    } else if (account) {
                        clearFieldError(this);
                    }
                });

                accountField.addEventListener('input', function() {
                    // Allow only numbers
                    this.value = this.value.replace(/\D/g, '').substring(0, 18);
                });
            }

            // Required field validation
            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        showFieldError(this, 'This field is required');
                    } else {
                        clearFieldError(this);
                    }
                });

                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        clearFieldError(this);
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 6;
            const form = document.getElementById('sellerRegistrationForm');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressFill = document.getElementById('progressFill');

            // Track email validation state
            let emailValidationState = {
                checked: false,
                available: false,
                message: ''
            };

            // Initialize
            updateStep(currentStep);

            // Attach real-time validation
            attachRealTimeValidation();

            // Next button click
            nextBtn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        updateStep(currentStep);
                    }
                }
            });

            // Previous button click
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateStep(currentStep);
                }
            });

            // Update step display
            function updateStep(step) {
                // Hide all steps
                document.querySelectorAll('.step-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Show current step
                document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');

                // Update progress bar
                const progress = ((step - 1) / (totalSteps - 1)) * 100;
                progressFill.style.width = progress + '%';

                // Update step indicators
                document.querySelectorAll('.step-circle').forEach((circle, index) => {
                    const stepNum = index + 1;
                    const stepLabel = circle.parentElement.querySelector('.step-label');

                    circle.classList.remove('active', 'completed');
                    stepLabel.classList.remove('active', 'completed');

                    if (stepNum < step) {
                        circle.classList.add('completed');
                        stepLabel.classList.add('completed');
                        circle.querySelector('.step-number').style.display = 'none';
                        circle.querySelector('.step-check').style.display = 'block';
                    } else if (stepNum === step) {
                        circle.classList.add('active');
                        stepLabel.classList.add('active');
                        circle.querySelector('.step-number').style.display = 'block';
                        circle.querySelector('.step-check').style.display = 'none';
                    } else {
                        circle.querySelector('.step-number').style.display = 'block';
                        circle.querySelector('.step-check').style.display = 'none';
                    }
                });

                // Update navigation buttons
                prevBtn.style.display = step > 1 ? 'flex' : 'none';
                nextBtn.style.display = step < totalSteps ? 'flex' : 'none';
                submitBtn.style.display = step === totalSteps ? 'flex' : 'none';

                // Update review data on last step
                if (step === totalSteps) {
                    updateReviewData();
                }

                // Scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // Validate current step
            function validateStep(step) {
                const currentStepElement = document.querySelector(`.step-content[data-step="${step}"]`);
                const requiredInputs = currentStepElement.querySelectorAll('[required]');
                let isValid = true;

                requiredInputs.forEach(input => {
                    const formGroup = input.closest('.form-group');
                    const errorElement = formGroup ? formGroup.querySelector('.form-error') : null;

                    let isEmpty = false;

                    // Check if it's a file input
                    if (input.type === 'file') {
                        isEmpty = !input.files || input.files.length === 0;
                    } else {
                        isEmpty = !input.value.trim();
                    }

                    if (isEmpty) {
                        input.classList.add('error');
                        if (errorElement) {
                            errorElement.classList.add('show');
                        }
                        // For file inputs, also highlight the upload area
                        if (input.type === 'file') {
                            const uploadArea = formGroup.querySelector('.upload-area');
                            if (uploadArea) {
                                uploadArea.classList.add('has-error');
                            }
                        }
                        isValid = false;
                    } else {
                        input.classList.remove('error');
                        if (errorElement) {
                            errorElement.classList.remove('show');
                        }
                        // For file inputs, also remove error styling from upload area
                        if (input.type === 'file') {
                            const uploadArea = formGroup.querySelector('.upload-area');
                            if (uploadArea) {
                                uploadArea.classList.remove('has-error');
                            }
                        }
                    }

                    // Special validation for email
                    if (input.type === 'email' && input.value) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(input.value)) {
                            input.classList.add('error');
                            if (errorElement) {
                                errorElement.classList.add('show');
                            }
                            isValid = false;
                        }
                    }

                    // Password confirmation
                    if (input.name === 'password_confirmation') {
                        const password = document.querySelector('input[name="password"]').value;
                        if (input.value !== password) {
                            input.classList.add('error');
                            if (errorElement) {
                                errorElement.classList.add('show');
                            }
                            isValid = false;
                        }
                    }
                });

                // Additional validation for step 1: Check if email is already taken
                if (step === 1) {
                    const emailField = document.getElementById('email');
                    if (emailField && emailField.value.trim()) {
                        // If email validation hasn't completed yet, force a check
                        if (!emailValidationState.checked) {
                            // Trigger the email validation manually
                            emailField.dispatchEvent(new Event('input'));

                            // Show error message
                            showValidationState('email', 'invalid', 'Please wait for email validation to complete');
                            isValid = false;
                        } else if (!emailValidationState.available) {
                            // Email is not available (already taken)
                            showValidationState('email', 'invalid', emailValidationState.message);
                            isValid = false;

                            // Focus on the email field
                            emailField.focus();
                            emailField.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                }

                return isValid;
            }

            // Update review data
            function updateReviewData() {
                console.log('Updating review data...'); // Debug log

                // Personal Information
                const nameField = document.querySelector('input[name="name"]');
                const emailField = document.querySelector('input[name="email"]');
                const phoneField = document.querySelector('input[name="phone"]');

                console.log('Name field:', nameField ? nameField.value : 'not found');
                console.log('Email field:', emailField ? emailField.value : 'not found');
                console.log('Phone field:', phoneField ? phoneField.value : 'not found');

                if (document.getElementById('review-name')) {
                    document.getElementById('review-name').textContent = nameField ? nameField.value || '-' : '-';
                }
                if (document.getElementById('review-email')) {
                    document.getElementById('review-email').textContent = emailField ? emailField.value || '-' :
                        '-';
                }
                if (document.getElementById('review-phone')) {
                    document.getElementById('review-phone').textContent = phoneField ? phoneField.value || '-' :
                        '-';
                }

                // Business Type
                const sellerTypeSelect = document.querySelector('select[name="seller_type_id"]');
                if (sellerTypeSelect && document.getElementById('review-business-type')) {
                    const selectedOption = sellerTypeSelect.options[sellerTypeSelect.selectedIndex];
                    document.getElementById('review-business-type').textContent = selectedOption.text !==
                        'Select Business Type' ? selectedOption.text : '-';
                }

                // Address Information
                const pincodeField = document.querySelector('input[name="pincode"]');
                const addressField = document.querySelector(
                    'textarea[name="address"]'); // Note: textarea, not input
                const areaField = document.querySelector('select[name="area"]');
                const cityField = document.querySelector('input[name="city"]');
                const stateField = document.querySelector('input[name="state"]');
                const countryField = document.querySelector('input[name="country"]');

                if (document.getElementById('review-pincode')) {
                    document.getElementById('review-pincode').textContent = pincodeField ? pincodeField.value ||
                        '-' : '-';
                }
                if (document.getElementById('review-address')) {
                    document.getElementById('review-address').textContent = addressField ? addressField.value ||
                        '-' : '-';
                }
                if (document.getElementById('review-area')) {
                    document.getElementById('review-area').textContent = areaField ? areaField.value || '-' : '-';
                }
                if (document.getElementById('review-city')) {
                    document.getElementById('review-city').textContent = cityField ? cityField.value || '-' : '-';
                }
                if (document.getElementById('review-state')) {
                    document.getElementById('review-state').textContent = stateField ? stateField.value || '-' :
                        '-';
                }
                if (document.getElementById('review-country')) {
                    document.getElementById('review-country').textContent = countryField ? countryField.value ||
                        '-' : '-';
                }

                // Store Information
                const businessNameField = document.querySelector('input[name="business_name"]');
                const storeAddressField = document.querySelector('textarea[name="store_address"]');

                if (document.getElementById('review-business-name')) {
                    document.getElementById('review-business-name').textContent = businessNameField ?
                        businessNameField.value || '-' : '-';
                }
                if (document.getElementById('review-store-address')) {
                    document.getElementById('review-store-address').textContent = storeAddressField ?
                        storeAddressField.value || '-' : '-';
                }

                // Bank Information
                const bankNameField = document.querySelector('input[name="bank_name"]');
                const holderNameField = document.querySelector('input[name="holder_name"]');
                const accountNoField = document.querySelector('input[name="account_no"]');
                const ifscCodeField = document.querySelector('input[name="ifsc_code"]');
                const branchField = document.querySelector('input[name="branch"]');

                if (document.getElementById('review-bank-name')) {
                    document.getElementById('review-bank-name').textContent = bankNameField ? bankNameField.value ||
                        '-' : '-';
                }
                if (document.getElementById('review-holder-name')) {
                    document.getElementById('review-holder-name').textContent = holderNameField ? holderNameField
                        .value || '-' : '-';
                }
                if (document.getElementById('review-account-no')) {
                    document.getElementById('review-account-no').textContent = accountNoField ? accountNoField
                        .value || '-' : '-';
                }
                if (document.getElementById('review-ifsc-code')) {
                    document.getElementById('review-ifsc-code').textContent = ifscCodeField ? ifscCodeField.value ||
                        '-' : '-';
                }
                if (document.getElementById('review-branch')) {
                    document.getElementById('review-branch').textContent = branchField ? branchField.value || '-' :
                        '-';
                }

                // Update documents review
                updateDocumentsReview();

                console.log('Review data update completed');
            }

            // Update documents review section
            function updateDocumentsReview() {
                const container = document.getElementById('review-documents');
                if (!container) {
                    console.log('Documents review container not found');
                    return;
                }

                // Get all file inputs, including dynamically created ones
                const fileInputs = document.querySelectorAll('input[type="file"]');
                let uploadedDocs = [];
                let missingDocs = [];

                console.log('Found file inputs:', fileInputs.length);

                fileInputs.forEach((input, index) => {
                    console.log(`File input ${index}:`, input.name, input.files.length > 0 ? 'has file' :
                        'no file');

                    // Skip non-document file inputs (like profile image, store logo, etc.)
                    if (input.name && (input.name.includes('document') || input.id.startsWith('doc_'))) {
                        const labelElement = input.closest('.form-group')?.querySelector('label');
                        const docName = labelElement ? labelElement.textContent.replace('*', '').trim() :
                            input.name;

                        if (input.files.length > 0) {
                            const fileName = input.files[0].name;
                            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2); // MB
                            uploadedDocs.push({
                                name: docName,
                                fileName: fileName,
                                fileSize: fileSize
                            });
                        } else if (input.hasAttribute('required')) {
                            missingDocs.push(docName);
                        }
                    }
                });

                console.log('Uploaded docs:', uploadedDocs);
                console.log('Missing docs:', missingDocs);

                let html = '';

                if (uploadedDocs.length > 0) {
                    uploadedDocs.forEach(doc => {
                        html += `
                    <div class="document-review-item uploaded">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong>${doc.name}</strong>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                    ${doc.fileName} (${doc.fileSize} MB)
        </div>
    </div>
                            <span class="document-status uploaded">✓ Uploaded</span>
</div>
                    </div>
                `;
                    });
                }

                if (missingDocs.length > 0) {
                    missingDocs.forEach(doc => {
                        html += `
                    <div class="document-review-item missing">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong>${doc}</strong>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                    Required document
                                </div>
                            </div>
                            <span class="document-status missing">⚠ Missing</span>
                        </div>
                    </div>
                `;
                    });
                }

                if (uploadedDocs.length === 0 && missingDocs.length === 0) {
                    html =
                        '<div class="review-item"><div class="review-label">Documents</div><div class="review-value">No documents required or uploaded yet</div></div>';
                }

                container.innerHTML = html;
            }

            // File upload handling with size validation
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const uploadArea = this.parentElement.querySelector('.upload-area');
                    const filenameElement = uploadArea.querySelector('.upload-filename');
                    const formGroup = this.closest('.form-group');
                    const errorElement = formGroup ? formGroup.querySelector('.form-error') : null;

                    if (this.files.length > 0) {
                        const file = this.files[0];
                        const filename = file.name;
                        const fileSize = file.size;
                        const maxSize = 5 * 1024 * 1024; // 5MB in bytes

                        // Check file size
                        if (fileSize > maxSize) {
                            const fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
                            filenameElement.textContent = `❌ File too large (${fileSizeMB}MB)`;
                            filenameElement.style.color = '#dc2626';
                            uploadArea.classList.remove('has-file');
                            uploadArea.classList.add('has-error');

                            if (errorElement) {
                                errorElement.textContent =
                                    `File size (${fileSizeMB}MB) exceeds the 5MB limit`;
                                errorElement.classList.add('show');
                            }

                            // Clear the file input
                            this.value = '';
                            return;
                        }

                        // File is valid
                        const fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
                        filenameElement.textContent = `✓ ${filename} (${fileSizeMB}MB)`;
                        filenameElement.style.color = '#059669';
                        uploadArea.classList.add('has-file');
                        uploadArea.classList.remove('has-error');

                        if (errorElement) {
                            errorElement.classList.remove('show');
                        }
                    } else {
                        filenameElement.textContent = '';
                        filenameElement.style.color = '';
                        uploadArea.classList.remove('has-file');
                        uploadArea.classList.remove('has-error');

                        if (errorElement) {
                            errorElement.classList.remove('show');
                        }
                    }

                    // Update documents review if we're on the review step
                    if (currentStep === totalSteps) {
                        updateDocumentsReview();
                    }
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Check terms acceptance
                if (!document.getElementById('terms_accepted').checked) {
                    alert('Please accept the terms and conditions');
                    return;
                }

                // Check confirmation acceptance
                if (!document.getElementById('confirmation_accepted').checked) {
                    alert('Please confirm that all information provided is accurate and complete');
                    return;
                }

                // Check for missing required documents and file sizes
                const requiredFileInputs = document.querySelectorAll('input[type="file"][required]');
                const allFileInputs = document.querySelectorAll('input[type="file"]');
                let missingDocs = [];
                let totalSize = 0;
                let oversizedFiles = [];

                // Check required documents
                requiredFileInputs.forEach(input => {
                    if (input.files.length === 0) {
                        const docName = input.closest('.form-group').querySelector('label')
                            .textContent.replace('*', '').trim();
                        missingDocs.push(docName);
                    }
                });

                // Check file sizes and calculate total
                allFileInputs.forEach(input => {
                    if (input.files.length > 0) {
                        const file = input.files[0];
                        const fileSize = file.size;
                        const maxSize = 5 * 1024 * 1024; // 5MB

                        totalSize += fileSize;

                        if (fileSize > maxSize) {
                            const docName = input.closest('.form-group').querySelector('label')
                                .textContent.replace('*', '').trim();
                            const fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
                            oversizedFiles.push(`${docName} (${fileSizeMB}MB)`);
                        }
                    }
                });

                if (missingDocs.length > 0) {
                    alert('Please upload all required documents: ' + missingDocs.join(', '));
                    return;
                }

                if (oversizedFiles.length > 0) {
                    alert('The following files exceed the 5MB limit: ' + oversizedFiles.join(', '));
                    return;
                }

                // Check total upload size (35MB limit to be safe)
                const maxTotalSize = 35 * 1024 * 1024; // 35MB
                if (totalSize > maxTotalSize) {
                    const totalSizeMB = (totalSize / 1024 / 1024).toFixed(2);
                    alert(
                        `Total file size (${totalSizeMB}MB) exceeds the 35MB limit. Please reduce file sizes or remove some files.`
                    );
                    return;
                }

                // Final confirmation dialog
                const confirmed = confirm(
                    'Are you sure you want to submit your seller registration? This action cannot be undone.'
                );
                if (!confirmed) {
                    return;
                }

                // Show spinner
                document.getElementById('submitSpinner').classList.add('show');
                submitBtn.disabled = true;

                // Submit the form
                submitBtn.textContent = 'Submitting...';
                console.log('All validations passed, submitting form');

                // Remove the event listener to prevent infinite loop and submit
                form.removeEventListener('submit', arguments.callee);
                form.submit();
            });

            // Remove error on input
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('error');
                    const errorElement = this.parentElement.querySelector('.form-error');
                    if (errorElement) {
                        errorElement.classList.remove('show');
                    }
                });
            });

            // Password toggle functionality
            window.togglePassword = function(inputId) {
                const input = document.getElementById(inputId);
                const toggleBtn = input.parentElement.querySelector('.password-toggle');
                const icon = toggleBtn.querySelector('.material-symbols-outlined');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility_off';
                }
            };

            // Business type change handler with debounce
            let documentLoadTimeout;
            const sellerTypeSelect = document.querySelector('select[name="seller_type_id"]');
            if (sellerTypeSelect && !sellerTypeSelect.hasAttribute('data-handler-attached')) {
                sellerTypeSelect.setAttribute('data-handler-attached', 'true');
                sellerTypeSelect.addEventListener('change', function() {
                    const sellerTypeId = this.value;
                    const container = document.getElementById('documentUploadContainer');

                    console.log('Business type changed to:', sellerTypeId); // Debug log

                    // Clear any existing timeout
                    if (documentLoadTimeout) {
                        clearTimeout(documentLoadTimeout);
                    }

                    if (sellerTypeId) {
                        // Show loading state immediately
                        container.innerHTML = `
                    <div class="text-center py-8">
                        <div class="spinner show mx-auto"></div>
                        <p class="mt-4 text-gray-600">Loading documents for selected business type...</p>
                    </div>
                `;

                        // Debounce the API call
                        documentLoadTimeout = setTimeout(() => {
                            loadDocumentRequirements(sellerTypeId);
                        }, 300);
                    } else {
                        clearDocumentRequirements();
                    }
                });
            }

            // Pincode API integration
            const pincodeInput = document.getElementById('pincode');
            const areaSelect = document.getElementById('area');
            const cityInput = document.getElementById('city');
            const stateInput = document.getElementById('state');
            const countryInput = document.getElementById('country');
            const pincodeLoader = document.querySelector('.pincode-loader');
            const pincodeInfo = document.querySelector('.pincode-info');

            let pincodeTimeout;

            pincodeInput.addEventListener('input', function() {
                const pincode = this.value.replace(/\D/g, ''); // Only digits
                this.value = pincode;

                // Clear previous data
                clearLocationData();

                if (pincode.length === 6) {
                    // Debounce API calls
                    clearTimeout(pincodeTimeout);
                    pincodeTimeout = setTimeout(() => {
                        fetchPincodeData(pincode);
                    }, 500);
                }
            });

            function fetchPincodeData(pincode) {
                // Show loader
                pincodeLoader.style.display = 'block';
                pincodeInfo.style.display = 'none';

                // Reset form validation state
                pincodeInput.classList.remove('error');
                const errorElement = pincodeInput.parentElement.querySelector('.form-error');
                if (errorElement) {
                    errorElement.classList.remove('show');
                }

                // Make API call using the provided endpoint
                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(response => response.json())
                    .then(data => {
                        pincodeLoader.style.display = 'none';

                        if (data && data[0] && data[0].Status === 'Success' && data[0].PostOffice) {
                            const postOffices = data[0].PostOffice;
                            populateLocationData(postOffices);
                            showPincodeInfo(
                                `Found ${postOffices.length} area(s) in ${postOffices[0].District}, ${postOffices[0].State}`
                            );
                        } else {
                            showPincodeError('Invalid pincode. Please check and try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching pincode data:', error);
                        pincodeLoader.style.display = 'none';
                        showPincodeError('Unable to fetch location data. Please try again.');
                    });
            }

            function populateLocationData(postOffices) {
                // Clear and populate area dropdown
                areaSelect.innerHTML = '<option value="">Select Area</option>';

                // Get unique areas and sort them
                const uniqueAreas = [...new Set(postOffices.map(po => po.Name))].sort();

                uniqueAreas.forEach(area => {
                    const option = document.createElement('option');
                    option.value = area;
                    option.textContent = area;
                    areaSelect.appendChild(option);
                });

                // Set city, state, and country from first post office
                const firstPostOffice = postOffices[0];
                cityInput.value = firstPostOffice.District || '';
                stateInput.value = firstPostOffice.State || '';
                countryInput.value = firstPostOffice.Country || 'India';

                // Enable area dropdown
                areaSelect.disabled = false;
            }

            function clearLocationData() {
                areaSelect.innerHTML = '<option value="">Select Area</option>';
                areaSelect.disabled = true;
                cityInput.value = '';
                stateInput.value = '';
                pincodeInfo.style.display = 'none';
            }

            function showPincodeInfo(message) {
                pincodeInfo.textContent = message;
                pincodeInfo.style.display = 'block';
                pincodeInfo.style.color = '#059669'; // Success color
            }

            function showPincodeError(message) {
                pincodeInput.classList.add('error');
                const errorElement = pincodeInput.parentElement.querySelector('.form-error');
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.add('show');
                }
                clearLocationData();
            }

            // Track loading state to prevent multiple simultaneous calls
            let isLoadingDocuments = false;
            let currentSellerTypeId = null;

            // Load document requirements based on seller type
            function loadDocumentRequirements(sellerTypeId) {
                // Prevent multiple simultaneous calls for the same seller type
                if (isLoadingDocuments && currentSellerTypeId === sellerTypeId) {
                    console.log('Already loading documents for seller type:', sellerTypeId);
                    return;
                }

                isLoadingDocuments = true;
                currentSellerTypeId = sellerTypeId;

                const container = document.getElementById('documentUploadContainer');
                container.innerHTML =
                    '<div class="text-center py-8"><div class="spinner show"></div><p class="mt-4">Loading documents...</p></div>';

                console.log('Loading documents for seller type:', sellerTypeId);

                fetch(`/seller/document-requirements?seller_type_id=${sellerTypeId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Document requirements received:', data); // Debug log
                        if (data.documents && data.documents.length > 0) {
                            // Remove duplicates by ID
                            const uniqueDocuments = data.documents.filter((doc, index, self) =>
                                index === self.findIndex(d => d.id === doc.id)
                            );
                            console.log('Unique documents from API:', uniqueDocuments); // Debug log
                            renderDocumentUploads(uniqueDocuments);
                        } else {
                            container.innerHTML = `
                        <div class="text-center text-gray-500 py-8">
                            <div class="text-2xl mb-2">📋</div>
                            <p>No specific documents required for this business type</p>
                        </div>
                    `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading documents:', error);
                        container.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <div class="text-2xl mb-2">❌</div>
                        <p>Error loading documents. Please try again.</p>
                    </div>
                `;
                    })
                    .finally(() => {
                        isLoadingDocuments = false;
                        currentSellerTypeId = null;
                    });
            }

            // Clear document requirements
            function clearDocumentRequirements() {
                const container = document.getElementById('documentUploadContainer');
                container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <div class="text-2xl mb-2">📋</div>
                <p>Please select a business type first to see required documents</p>
            </div>
        `;
            }

            // Render document upload fields
            function renderDocumentUploads(documents) {
                const container = document.getElementById('documentUploadContainer');

                // Clear container completely
                container.innerHTML = '';

                // Remove duplicates by ID and name - more aggressive deduplication
                const seenIds = new Set();
                const seenNames = new Set();
                const uniqueDocuments = documents.filter(doc => {
                    const isDuplicateId = seenIds.has(doc.id);
                    const isDuplicateName = seenNames.has(doc.name);

                    if (!isDuplicateId && !isDuplicateName) {
                        seenIds.add(doc.id);
                        seenNames.add(doc.name);
                        return true;
                    }
                    return false;
                });

                console.log('Original documents count:', documents.length);
                console.log('Unique documents count:', uniqueDocuments.length);
                console.log('Rendering documents:', uniqueDocuments);

                if (uniqueDocuments.length === 0) {
                    container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <div class="text-2xl mb-2">📋</div>
                    <p>No documents required for this business type</p>
                </div>
            `;
                    return;
                }

                // Group documents by mandatory status
                const mandatoryDocs = uniqueDocuments.filter(doc => doc.mandatory);
                const optionalDocs = uniqueDocuments.filter(doc => !doc.mandatory);

                let html = '';

                // Render mandatory documents first
                if (mandatoryDocs.length > 0) {
                    html += '<div class="document-section">';
                    html += '<h3 class="document-section-title">Required Documents</h3>';
                    html += '<div class="document-grid">';

                    mandatoryDocs.forEach((doc, index) => {
                        html += createDocumentUploadField(doc, index, true);
                    });

                    html += '</div></div>';
                }

                // Render optional documents
                if (optionalDocs.length > 0) {
                    html += '<div class="document-section">';
                    html += '<h3 class="document-section-title">Optional Documents</h3>';
                    html += '<div class="document-grid">';

                    optionalDocs.forEach((doc, index) => {
                        html += createDocumentUploadField(doc, mandatoryDocs.length + index, false);
                    });

                    html += '</div></div>';
                }

                // Set the HTML content
                container.innerHTML = html;

                // Small delay to ensure DOM is updated before attaching handlers
                setTimeout(() => {
                    attachFileUploadHandlers();
                }, 100);
            }

            // Create document upload field HTML
            function createDocumentUploadField(doc, index, isRequired) {
                const fieldId = `doc_${doc.id}`;
                const requiredText = isRequired ? '<span class="required">*</span>' : '';
                const requiredAttr = isRequired ? 'required' : '';

                return `
            <div class="form-group">
                <label class="form-label">${doc.name} ${requiredText}</label>
                <div class="upload-area" onclick="document.getElementById('${fieldId}').click()">
                    <div class="upload-icon">📄</div>
                    <div class="upload-text">Upload ${doc.name}</div>
                    <div class="upload-hint">PDF, JPG, PNG (Max 5MB)</div>
                    <div class="upload-filename"></div>
                </div>
                <input type="file" id="${fieldId}" name="documents[${doc.id}]" 
                       accept=".pdf,.jpg,.jpeg,.png" style="display: none;" ${requiredAttr}>
                ${doc.description ? `<p class="text-xs text-gray-500 mt-1">${doc.description}</p>` : ''}
</div>
        `;
            }

            // Attach file upload handlers to new elements
            function attachFileUploadHandlers() {
                document.querySelectorAll('input[type="file"]').forEach(input => {
                    if (!input.hasAttribute('data-handler-attached')) {
                        input.setAttribute('data-handler-attached', 'true');
                        input.addEventListener('change', function() {
                            const uploadArea = this.parentElement.querySelector('.upload-area');
                            const filenameElement = uploadArea.querySelector('.upload-filename');
                            const formGroup = this.closest('.form-group');
                            const errorElement = formGroup ? formGroup.querySelector(
                                '.form-error') : null;

                            if (this.files.length > 0) {
                                const file = this.files[0];
                                const filename = file.name;
                                const fileSize = file.size;
                                const maxSize = 5 * 1024 * 1024; // 5MB in bytes

                                // Check file size
                                if (fileSize > maxSize) {
                                    const fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
                                    filenameElement.textContent =
                                        `❌ File too large (${fileSizeMB}MB)`;
                                    filenameElement.style.color = '#dc2626';
                                    uploadArea.classList.remove('has-file');
                                    uploadArea.classList.add('has-error');

                                    if (errorElement) {
                                        errorElement.textContent =
                                            `File size (${fileSizeMB}MB) exceeds the 5MB limit`;
                                        errorElement.classList.add('show');
                                    }

                                    // Clear the file input
                                    this.value = '';
                                    return;
                                }

                                // File is valid
                                const fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
                                filenameElement.textContent = `✓ ${filename} (${fileSizeMB}MB)`;
                                filenameElement.style.color = '#059669';
                                uploadArea.classList.add('has-file');
                                uploadArea.classList.remove('has-error');

                                if (errorElement) {
                                    errorElement.classList.remove('show');
                                }
                            } else {
                                filenameElement.textContent = '';
                                filenameElement.style.color = '';
                                uploadArea.classList.remove('has-file');
                                uploadArea.classList.remove('has-error');

                                if (errorElement) {
                                    errorElement.classList.remove('show');
                                }
                            }

                            // Update documents review if we're on the review step
                            if (currentStep === totalSteps) {
                                updateDocumentsReview();
                            }
                        });
                    }
                });
            }

            // Add validation event listeners when DOM is loaded
            let emailTimeout, panTimeout, gstTimeout;

            // Email validation
            const emailField = document.getElementById('email');
            if (emailField) {
                emailField.addEventListener('input', function() {
                    clearTimeout(emailTimeout);
                    const email = this.value.trim();

                    if (!email) {
                        showValidationState('email', 'invalid', 'Email is required');
                        emailValidationState = {
                            checked: false,
                            available: false,
                            message: 'Email is required'
                        };
                        return;
                    }

                    showValidationState('email', 'checking', '');
                    emailValidationState = {
                        checked: false,
                        available: false,
                        message: 'Checking email availability...'
                    };

                    emailTimeout = setTimeout(() => {
                        checkEmailAvailability(email).then(result => {
                            emailValidationState = {
                                checked: true,
                                available: result.available,
                                message: result.message
                            };
                            if (result.available) {
                                showValidationState('email', 'valid', result.message);
                            } else {
                                showValidationState('email', 'invalid', result.message);
                            }
                        }).catch(error => {
                            console.error('Email validation error:', error);
                            emailValidationState = {
                                checked: false,
                                available: false,
                                message: 'Unable to verify email. Please try again.'
                            };
                            showValidationState('email', 'invalid',
                                'Unable to verify email. Please try again.');
                        });
                    }, 800);
                });
            }

            // Phone validation
            const phoneField = document.getElementById('phone');
            if (phoneField) {
                // Only allow digits
                phoneField.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');

                    const phone = this.value.trim();

                    if (!phone) {
                        showValidationState('phone', 'invalid', 'Phone number is required');
                        return;
                    }

                    if (phone.length < 10) {
                        showValidationState('phone', 'invalid', 'Phone number must be 10 digits');
                        return;
                    }

                    // Basic phone format validation
                    if (validatePhone(phone)) {
                        showValidationState('phone', 'valid', 'Valid phone number format');
                    } else {
                        showValidationState('phone', 'invalid',
                            'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9');
                    }
                });
            }

            // PAN validation
            const panField = document.getElementById('pan_number');
            if (panField) {
                panField.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();

                    clearTimeout(panTimeout);
                    const pan = this.value.trim();

                    if (!pan) {
                        showValidationState('pan_number', 'invalid', 'PAN number is required');
                        return;
                    }

                    if (pan.length < 10) {
                        showValidationState('pan_number', 'invalid', 'PAN number must be 10 characters');
                        return;
                    }

                    showValidationState('pan_number', 'checking', '');

                    panTimeout = setTimeout(() => {
                        checkPANAvailability(pan).then(result => {
                            if (result.available) {
                                showValidationState('pan_number', 'valid', result.message);
                            } else {
                                showValidationState('pan_number', 'invalid', result
                                    .message);
                            }
                        }).catch(error => {
                            console.error('PAN validation error:', error);
                            showValidationState('pan_number', 'invalid',
                                'Unable to verify PAN number. Please try again.');
                        });
                    }, 800);
                });
            }

            // GST validation
            const gstField = document.getElementById('gst_number');
            if (gstField) {
                gstField.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();

                    clearTimeout(gstTimeout);
                    const gst = this.value.trim();

                    if (!gst) {
                        showValidationState('gst_number', 'valid', 'GST number is optional');
                        return;
                    }

                    if (gst.length < 15) {
                        showValidationState('gst_number', 'invalid', 'GST number must be 15 characters');
                        return;
                    }

                    showValidationState('gst_number', 'checking', '');

                    gstTimeout = setTimeout(() => {
                        checkGSTAvailability(gst).then(result => {
                            if (result.available) {
                                showValidationState('gst_number', 'valid', result.message);
                            } else {
                                showValidationState('gst_number', 'invalid', result
                                    .message);
                            }
                        }).catch(error => {
                            console.error('GST validation error:', error);
                            showValidationState('gst_number', 'invalid',
                                'Unable to verify GST number. Please try again.');
                        });
                    }, 800);
                });
            }
        });
    </script>
@endsection
