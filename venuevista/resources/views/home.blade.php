<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VenueVista | Curated Event Spaces</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,500&family=Inter:wght@300;400;500;600&display=swap');

        :root {
            /* Updated Color Theme - Green */
            --primary: #1f4d3a;       /* Dark Green */
            --primary-soft: #2e6b55;  /* Medium Green */
            --text-primary: #1f4d3a;  /* Green for text (was blue) */
            --accent: #9fd36c;        /* Light Green */

            --bg-main: #f7f6f2;
            --bg-card: #ffffff;
            --bg-section: #eef1ec;    /* Light green background for sections */

            --text-heading: #1c2b25;
            --text-body: #4b5a55;
            --text-muted: #7b8a84;

            --border-soft: #e3e6e2;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.08);

            --radius-lg: 28px;
            --radius-md: 18px;
            --radius-sm: 12px;
            --radius-pill: 999px;

            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-body);
            line-height: 1.6;
        }

        .serif {
            font-family: 'Playfair Display', serif;
            color: var(--text-heading);
        }
        .italic { font-style: italic; }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
            color: var(--text-heading);
        }

        /* REDUCED Section Padding */
        .section-padding {
            padding: 60px 0; /* Reduced from 80px */
        }

        @media (max-width: 768px) {
            .section-padding {
                padding: 40px 0; /* Reduced from 60px */
            }
        }

        /* Utility Classes */
        .text-primary { color: var(--text-primary) !important; } /* Now green */
        .text-accent { color: var(--accent); }
        .text-muted { color: var(--text-muted); }

        .bg-main { background-color: var(--bg-main); }
        .bg-card { background-color: var(--bg-card); }
        .bg-section { background-color: var(--bg-section); }
    </style>
</head>
<body>

    <!-- UI 2 Navigation -->
    <nav class="vv-navbar-fixed">
        <div class="container">
            <div class="nav-inner">

                <div class="brand serif">Venue<span class="italic">Vista</span></div>
                <div class="navbar-actions">
    @guest
        <a href="{{ route('login') }}" class="nav-link">Sign In</a>
        <a href="{{ route('register') }}" class="btn-main">Get Started</a>
    @else
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn-account">
                <i class="fas fa-user-circle me-1"></i> <span>Admin Dashboard</span>
            </a>
        @else
            <a href="{{ route('user.dashboard') }}" class="btn-account">
                <i class="fas fa-user-circle me-1"></i> <span>My Dashboard</span>
            </a>
        @endif
    @endguest
</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- UI 2 Hero Section -->
        <header class="container">
            <div class="hero">
                <div>
                    <h1 class="serif">Beautiful venues<br>for meaningful<br><span class="italic">celebrations</span></h1>
                    <p class="text-muted">Thoughtfully curated spaces for weddings, gatherings and unforgettable moments.</p>
                    <div class="hero-actions">
                        <a href="{{ auth()->check() ? '/user/venues' : '/register' }}" class="btn-main">
                            Explore Venues
                        </a>
                    </div>
                </div>
                <img src="/images/hero.jpg" alt="Elegant Wedding Venue">
            </div>
        </header>

        <!-- UI 2 Collections Section (Circular) -->
        <section class="section-padding" id="collections">
            <div class="container">
                <h2 class="section-title serif text-center">Curated <span class="italic">Collections</span></h2>
                <p class="section-subtitle text-center text-muted">Spaces for every kind of event</p>

                <div class="collections-grid">
                    <div class="collection-item">
                        <img src="/images/wedding-event.jpg" alt="Weddings">
                        <span class="serif">Weddings</span>
                    </div>
                    <div class="collection-item">
                        <img src="/images/private-event.jpg" alt="Private Events">
                        <span class="serif">Private Events</span>
                    </div>
                    <div class="collection-item">
                        <img src="/images/corporate-events.webp" alt="Corporate">
                        <span class="serif">Corporate</span>
                    </div>
                    <div class="collection-item">
                        <img src="/images/birthday.webp" alt="Birthdays">
                        <span class="serif">Birthdays</span>
                    </div>
                    <div class="collection-item">
                        <img src="/images/engagement.jpg" alt="Engagements">
                        <span class="serif">Engagements</span>
                    </div>
                    <div class="collection-item">
                        <img src="/images/conference.webp" alt="Conferences">
                        <span class="serif">Conferences</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- UI 1 Featured Venues Section -->
        <section class="section-padding" id="featured">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="serif h1 mb-3">
                        <span class="italic">Featured</span> Venues
                    </h2>
                    <p class="text-muted">Handpicked spaces for unforgettable events</p>
                </div>

                <div class="venues-grid">
                   @foreach ($venues->take(3) as $venue)
                        <div class="venue-card">
                            <div class="venue-image">
                                <img src="{{ $venue->images[0] }}" alt="{{ $venue->name }}">
                                <div class="venue-price-badge">
                                    ₹{{ $venue->pricePerHour }}/hr
                                </div>
                            </div>

                            <div class="venue-content">
                                <h3 class="venue-name serif">{{ $venue->name }}</h3>

                                <div class="venue-info">
                                    <div class="venue-location mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <span>{{ $venue->location }}</span>
                                    </div>
                                    <div class="venue-capacity">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        <span>Up to {{ $venue->capacity }} guests</span>
                                    </div>
                                </div>

                                <a href="{{ auth()->check() ? '/user/venues/' . $venue->_id : '/login' }}"
                                   class="btn-venue-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ auth()->check() ? '/user/venues' : '/register' }}" class="btn-view-all">
                        View All Venues
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- UI 1 Why Choose Us Section - Updated circles color -->
        <section class="section-padding">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="serif h1 mb-3">
                        Why <span class="italic text-primary">Choose</span> VenueVista
                    </h2>
                    <p class="text-muted">Simple, secure, and stress-free venue booking</p>
                </div>

                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h4 class="serif h5 mb-2">Verified Venues</h4>
                        <p class="small text-muted">Every venue is inspected and quality-approved</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4 class="serif h5 mb-2">Instant Booking</h4>
                        <p class="small text-muted">Real-time availability with instant confirmation</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="serif h5 mb-2">24/7 Support</h4>
                        <p class="small text-muted">Dedicated support throughout your booking journey</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- UI 1 Final CTA -->
        <section class="section-padding">
            <div class="container">
                <div class="cta-final text-center">
                    <h2 class="serif h1 mb-3">
                        Ready to Find Your <span class="italic text-primary">Perfect</span> Venue?
                    </h2>
                    <p class="mb-4 text-muted">
                        Join thousands who've booked their dream venue with VenueVista
                    </p>
                    <a href="{{ auth()->check() ? '/user/venues' : '/register' }}" class="btn-cta-primary">
                        Start Exploring
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- UI 1 Footer (Updated colors) -->
    <footer class="footer-simple">
        <div class="container">
            <div class="text-center mb-4">
                <a href="/" class="footer-logo serif">
                    Venue<span class="italic text-primary">Vista</span>
                </a>
                <p class="text-muted mt-2">Beautiful venues for beautiful moments</p>
            </div>

            <div class="footer-links text-center mb-4">
                <a href="/user/venues" class="footer-link">Browse Venues</a>
                <a href="#" class="footer-link">How It Works</a>
                <a href="#" class="footer-link">Contact</a>
                <a href="#" class="footer-link">Privacy</a>
            </div>

            <div class="social-icons text-center mb-4">
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
            </div>

            <div class="text-center">
                <p class="small text-muted">&copy; 2023 VenueVista. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <style>
        /* Container */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* UI 2 Navigation Styles */
        .vv-navbar-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(247, 246, 242, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-soft);
            z-index: 1000;
            padding: 0;
        }

        .nav-inner {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-links {
            display: flex;
            gap: 24px;
        }

        .nav-link {
            color: var(--text-muted);
            font-size: 14px;
            text-decoration: none;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--text-primary);
        }

        .brand {
            font-size: 26px;
            font-weight: 600;
            color: var(--text-heading);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-main {
            padding: 10px 22px;
            border-radius: var(--radius-pill);
            background: var(--primary);
            color: white;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            border: none;
        }

        .btn-main:hover {
            background: var(--primary-soft);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-account {
            background: var(--bg-card);
            color: var(--text-body);
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border-soft);
            transition: var(--transition);
        }

        .btn-account:hover {
            border-color: var(--text-primary);
            color: var(--text-primary);
        }

        /* UI 2 Hero Section */
        header {
            padding-top: 140px;
            padding-bottom: 100px; /* Reduced */
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero h1 {
            font-size: 56px;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        .hero p {
            max-width: 420px;
            color: var(--text-muted);
            margin-bottom: 32px;
            font-size: 16px;
            line-height: 1.6;
        }

        .hero img {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            width: 100%;
            height: 330px;
            object-fit: cover;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        /* UI 2 Collections Section (Circular) */
        .section-title {
            text-align: center;
            font-size: 42px;
            margin-bottom: 10px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 50px;
            font-size: 16px;
        }

        .collections-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 24px;
            justify-items: center;
        }

        .collection-item {
            text-align: center;
            transition: var(--transition);
        }

        .collection-item:hover {
            transform: translateY(-5px);
        }

        .collection-item img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: var(--shadow);
            margin-bottom: 12px;
            transition: var(--transition);
        }

        .collection-item:hover img {
            transform: scale(1.05);
        }

        .collection-item span {
            font-size: 16px;
            font-weight: 500;
        }

        /* UI 1 Featured Venues */
        .venues-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        @media (max-width: 992px) {
            .venues-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .venues-grid {
                grid-template-columns: 1fr;
            }
        }

        .venue-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .venue-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        .venue-image {
            position: relative;
            height: 240px;
            overflow: hidden;
        }

        .venue-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .venue-card:hover .venue-image img {
            transform: scale(1.05);
        }

        .venue-price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            padding: 6px 14px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 14px;
        }

        .venue-content {
            padding: 22px;
        }

        .venue-name {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-heading);
        }

        .venue-info {
            border-top: 1px solid var(--border-soft);
            border-bottom: 1px solid var(--border-soft);
            padding: 12px 0;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .btn-venue-primary {
            background: var(--primary);
            color: white;
            padding: 12px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            text-align: center;
            display: block;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-venue-primary:hover {
            background: var(--primary-soft);
            transform: translateY(-2px);
        }

        .btn-view-all {
            font-weight: 600;
            font-size: 16px;
            color: var(--text-primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }

        .btn-view-all:hover {
            color: var(--accent);
            transform: translateX(5px);
        }

        /* UI 1 Why Choose Us - Updated circles color */
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        @media (max-width: 768px) {
            .benefits-grid {
                grid-template-columns: 1fr;
            }
        }

        .benefit-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-soft);
            transition: var(--transition);
            text-align: center;
            padding: 40px 30px;
        }

        .benefit-card:hover {
            border-color: var(--text-primary);
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            background: var(--bg-section); /* Updated to light green (same as ready to find section) */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary); /* Green color */
            font-size: 24px;
            margin: 0 auto 20px;
            transition: var(--transition);
        }

        .benefit-card:hover .benefit-icon {
            background: var(--accent);
        }

        .benefit-card h4 {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: var(--text-heading);
        }

        .benefit-card p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .small {
            font-size: 14px;
        }

        /* UI 1 Final CTA */
        .cta-final {
            background: var(--bg-section); /* Light green background */
            border: 2px solid var(--primary-soft);
            border-radius: var(--radius-lg);
            padding: 60px 40px;
            text-align: center;
        }

        .cta-final h2 {
            font-size: 2.5rem;
            margin-bottom: 16px;
        }

        .cta-final p {
            font-size: 1.125rem;
            margin-bottom: 32px;
        }

        .btn-cta-primary {
            background: var(--primary);
            color: white;
            padding: 15px 40px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 16px;
            display: inline-block;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-cta-primary:hover {
            background: var(--primary-soft);
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        /* UI 1 Footer */
        .footer-simple {
            background: var(--bg-main);
            border-top: 1px solid var(--border-soft);
            text-align: center;
            padding: 60px 20px 30px;
        }

        .footer-logo {
            font-size: 28px;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-heading);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .footer-link {
            color: var(--text-muted);
            font-size: 14px;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--text-primary);
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-icon {
            width: 36px;
            height: 36px;
            border: 1px solid var(--border-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-icon:hover {
            border-color: var(--text-primary);
            color: var(--text-primary);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero p {
                margin: 0 auto 32px;
            }

            .hero-actions {
                justify-content: center;
            }

            .collections-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 30px;
            }

            .section-title {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .nav-inner {
                flex-direction: column;
                height: auto;
                padding: 15px 0;
                gap: 15px;
            }

            .nav-links {
                order: 2;
            }

            .brand {
                order: 1;
            }

            .navbar-actions {
                order: 3;
            }

            header {
                padding-top: 180px;
                padding-bottom: 80px; /* Reduced */
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero img {
                height: 400px;
            }

            .collections-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .collection-item img {
                width: 120px;
                height: 120px;
            }

            .cta-final {
                padding: 40px 20px;
            }

            .cta-final h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 28px;
            }

            .hero img {
                height: 300px;
            }

            .collections-grid {
                grid-template-columns: 1fr;
            }

            .collection-item img {
                width: 150px;
                height: 150px;
            }

            .venues-grid {
                grid-template-columns: 1fr;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .benefit-card {
                padding: 30px 20px;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Improved spacing */
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .mb-5 { margin-bottom: 2rem !important; }
        .mt-2 { margin-top: 0.5rem !important; }
        .mt-4 { margin-top: 1.5rem !important; }
        .mt-5 { margin-top: 2rem !important; }

        h1 { font-size: 3.5rem; }
        h2 { font-size: 2.5rem; }
        h3 { font-size: 2rem; }
        h4 { font-size: 1.5rem; }
        h5 { font-size: 1.25rem; }

        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            h2 { font-size: 2rem; }
            h3 { font-size: 1.75rem; }
            h4 { font-size: 1.25rem; }
        }
    </style>

    <script>
        // Smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') return;

                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.vv-navbar-fixed');
                if (window.scrollY > 50) {
                    navbar.style.background = 'rgba(247, 246, 242, 0.98)';
                    navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
                } else {
                    navbar.style.background = 'rgba(247, 246, 242, 0.95)';
                    navbar.style.boxShadow = 'none';
                }
            });

            // Animation on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            // Set initial styles for animation
            document.querySelectorAll('.collection-item, .venue-card, .benefit-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>