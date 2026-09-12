@extends('layouts.main')

@section('content')
<style>
    /* Register Page Specific Styles - Import Fonts First */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,500&family=Inter:wght@300;400;500;600;700&display=swap');

    .register-container {
        min-height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-main);
        padding: 60px 20px;

    }

    .register-wrapper {
        width: 100%;
        max-width: 520px; /* Wider card */
        animation: fadeInUp 0.6s ease;
    }

    .register-logo {
        text-align: center;
        margin-bottom: 40px;
    }

    .register-logo .brand {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--text-heading);
        text-decoration: none;
        display: inline-block;
        margin-bottom: 8px;
    }

    .register-logo .brand span {
        color: var(--primary);
        font-style: italic;
    }

    .register-logo p {
        color: var(--text-muted);
        font-size: 15px;
        margin: 0;
    }

    .register-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-soft);
    }

    .register-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .register-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .register-header p {
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.5;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-heading);
        font-size: 14px;
        font-family: 'Inter', sans-serif;
    }

    .input-group {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        background: white;
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-md);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        color: var(--text-body);
        transition: all 0.2s ease;
    }

    /* Minimalist Focus State */
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(31, 77, 58, 0.08);
    }

    .form-control::placeholder {
        color: #a8b5b0;
        font-weight: 400;
    }

    .input-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        height: 20px;
        width: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle:hover {
        color: var(--primary);
    }

    .form-text {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .btn-register {
        width: 100%;
        padding: 14px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: var(--radius-pill);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 8px;
    }

    .btn-register:hover {
        background: var(--primary-soft);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border-soft);
    }

    .login-link p {
        color: var(--text-muted);
        font-size: 15px;
        margin: 0;
    }

    .login-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .login-link a:hover {
        color: var(--primary-soft);
        text-decoration: underline;
    }

    .form-message {
        padding: 12px 16px;
        border-radius: var(--radius-md);
        margin-bottom: 24px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideDown 0.3s ease;
    }

    .form-message.error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .form-message.success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .password-strength {
        margin-top: 8px;
        height: 4px;
        background: var(--border-soft);
        border-radius: var(--radius-pill);
        overflow: hidden;
        position: relative;
    }

    .password-strength-bar {
        height: 100%;
        width: 0;
        border-radius: var(--radius-pill);
        transition: width 0.3s ease;
        background: var(--primary);
    }

    .password-requirements {
        margin-top: 12px;
        font-size: 13px;
        color: var(--text-muted);
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .requirement {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .requirement i {
        font-size: 12px;
        color: #cbd5e1;
    }

    .requirement.valid i {
        color: var(--primary);
    }

    .requirement.valid {
        color: var(--primary);
    }

    /* Password Match Indicator */
    .password-match {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        font-size: 13px;
    }

    .password-match.valid {
        color: var(--primary);
    }

    .password-match.invalid {
        color: #ef4444;
    }

    /* Animations */
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

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .register-container {
            padding: 40px 16px;
            margin-top: 70px;
        }

        .register-wrapper {
            max-width: 100%;
        }

        .register-card {
            padding: 32px 24px;
        }

        .register-header h2 {
            font-size: 28px;
        }

        .password-requirements {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 32px 12px;
        }

        .register-card {
            padding: 24px 20px;
            border-radius: var(--radius-md);
        }

        .register-header h2 {
            font-size: 24px;
        }

        .form-control {
            padding: 12px 14px;
            font-size: 14px;
        }

        .btn-register {
            padding: 12px;
            font-size: 14px;
        }
    }
</style>

<div class="register-container">
    <div class="register-wrapper">
        <div class="register-logo">
            <a href="/" class="brand">Venue<span class="italic">Vista</span></a>
            <p>Join our community of event planners</p>
        </div>

        <div class="register-card">
            <div class="register-header">
                <h2>Create Account</h2>
                <p>Sign up to discover perfect venues for your special moments</p>
            </div>

            @if ($errors->any())
                <div class="form-message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="/register" method="POST" id="registerForm">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="name" name="name" required
                               placeholder="Enter your full name" value="{{ old('name') }}">
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" required
                               placeholder="you@example.com" value="{{ old('email') }}">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                               minlength="6" required placeholder="Create a password">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrength"></div>
                    </div>
                    <div class="password-requirements">
                        <div class="requirement" id="reqLength">
                            <i class="fas fa-circle"></i>
                            <span>6+ characters</span>
                        </div>
                        <div class="requirement" id="reqUppercase">
                            <i class="fas fa-circle"></i>
                            <span>Uppercase letter</span>
                        </div>
                        <div class="requirement" id="reqLowercase">
                            <i class="fas fa-circle"></i>
                            <span>Lowercase letter</span>
                        </div>
                        <div class="requirement" id="reqNumber">
                            <i class="fas fa-circle"></i>
                            <span>Number</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword"
                               name="confirmPassword" required placeholder="Re-enter password">
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-match" id="passwordMatch"></div>
                </div>

                <button type="submit" class="btn-register">
                    Create Account
                </button>

                <div class="login-link">
                    <p>Already have an account? <a href="/login">Sign in here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Password strength checker
        const password = document.getElementById('password');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordMatch = document.getElementById('passwordMatch');
        const confirmPassword = document.getElementById('confirmPassword');

        // Requirement elements
        const reqLength = document.getElementById('reqLength');
        const reqUppercase = document.getElementById('reqUppercase');
        const reqLowercase = document.getElementById('reqLowercase');
        const reqNumber = document.getElementById('reqNumber');

        password.addEventListener('input', function() {
            const pass = this.value;
            let strength = 0;

            // Check requirements
            const hasLength = pass.length >= 6;
            const hasUppercase = /[A-Z]/.test(pass);
            const hasLowercase = /[a-z]/.test(pass);
            const hasNumber = /[0-9]/.test(pass);

            // Update requirement indicators
            updateRequirement(reqLength, hasLength);
            updateRequirement(reqUppercase, hasUppercase);
            updateRequirement(reqLowercase, hasLowercase);
            updateRequirement(reqNumber, hasNumber);

            // Calculate strength
            if (hasLength) strength += 25;
            if (hasUppercase) strength += 25;
            if (hasLowercase) strength += 25;
            if (hasNumber) strength += 25;

            // Update strength bar
            passwordStrength.style.width = strength + '%';

            // Update color based on strength
            if (strength < 50) {
                passwordStrength.style.backgroundColor = '#ef4444';
            } else if (strength < 75) {
                passwordStrength.style.backgroundColor = '#f59e0b';
            } else {
                passwordStrength.style.backgroundColor = '#10b981';
            }

            // Check password match
            checkPasswordMatch();
        });

        confirmPassword.addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            const pass = password.value;
            const confirmPass = confirmPassword.value;

            if (confirmPass.length === 0) {
                passwordMatch.textContent = '';
                passwordMatch.className = 'password-match';
                return;
            }

            if (pass === confirmPass) {
                passwordMatch.innerHTML = '<i class="fas fa-check-circle"></i> Passwords match';
                passwordMatch.className = 'password-match valid';
            } else {
                passwordMatch.innerHTML = '<i class="fas fa-times-circle"></i> Passwords do not match';
                passwordMatch.className = 'password-match invalid';
            }
        }

        function updateRequirement(element, isValid) {
            if (isValid) {
                element.classList.add('valid');
                element.querySelector('i').className = 'fas fa-check-circle';
            } else {
                element.classList.remove('valid');
                element.querySelector('i').className = 'fas fa-circle';
            }
        }

        // Form submission validation
        const form = document.getElementById('registerForm');
        form.addEventListener('submit', function(e) {
            const pass = password.value;
            const confirmPass = confirmPassword.value;

            if (pass !== confirmPass) {
                e.preventDefault();
                alert('Passwords do not match. Please check and try again.');
                password.focus();
                return false;
            }

            if (pass.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                password.focus();
                return false;
            }

            // Add loading state
            const submitBtn = form.querySelector('.btn-register');
            const originalText = submitBtn.textContent;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
            submitBtn.disabled = true;

            // Reset button after 5 seconds if form doesn't submit
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });

        // Add focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.zIndex = '1';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.zIndex = '0';
            });
        });
    });
</script>
@endpush
@endsection