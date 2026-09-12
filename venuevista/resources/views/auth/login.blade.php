@extends('layouts.main')

@section('content')
<style>
    /* Login Page Specific Styles - Using VenueVista Design System */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,500&family=Inter:wght@300;400;500;600;700&display=swap');

    .login-container {

        min-height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-main);
        padding: 60px 20px;

    }

    .login-wrapper {
        width: 100%;
        max-width: 480px;
        animation: fadeInUp 0.6s ease;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-logo .brand {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--text-heading);
        text-decoration: none;
        display: inline-block;
        margin-bottom: 8px;
    }

    .login-logo .brand span {
        color: var(--primary);
        font-style: italic;
    }

    .login-logo p {
        color: var(--text-muted);
        font-size: 15px;
        margin: 0;
    }

    .login-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-soft);
    }

    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .login-header p {
        color: var(--text-muted);
        font-size: 15px;
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

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(31, 77, 58, 0.08);
    }

    .input-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    .admin-hint {
        background: #f8fafc;
        border: 1px dashed var(--border-soft);
        padding: 15px;
        border-radius: var(--radius-md);
        margin-bottom: 24px;
    }

    .admin-hint p {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-heading);
        margin-bottom: 5px;
    }

    .admin-hint code {
        display: block;
        font-size: 12px;
        color: var(--primary);
    }

    .btn-login {
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
    }

    .btn-login:hover {
        background: var(--primary-soft);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .register-link {
        text-align: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border-soft);
    }

    .register-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="login-container">
    <div class="login-wrapper">
        <div class="login-logo">
            <a href="/" class="brand">Venue<span>Vista</span></a>
            <p>Welcome back, please sign in</p>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h2>Login</h2>
                <p>Manage your venues and bookings</p>
            </div>

            <form action="/login" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>

                <div class="register-link">
                    <p>Don't have an account? <a href="/register">Register here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection