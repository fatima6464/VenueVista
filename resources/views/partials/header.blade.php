<nav class="vv-navbar-fixed">
    <div class="container">
        <div class="nav-inner">
            <div class="brand serif">Venue<span class="italic">Vista</span></div>
            <div class="navbar-actions">
                @guest
                    <a href="/login" class="nav-link">Sign In</a>
                    <a href="/register" class="btn-main">Get Started</a>
                @else
                    <a href="/user/dashboard" class="nav-link">Dashboard</a>
                    <a href="/user/venues" class="nav-link">Explore Venues</a>

                    <a href="/logout" class="btn-account">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        <span>Logout</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>
<style>
    /* Navbar Styles */
.vv-navbar-fixed {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(247, 246, 242, 0.95);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid var(--border-soft);
    z-index: 1000;
    padding: 0;
    transition: var(--transition);
}

.vv-navbar-fixed.scrolled {
    background: rgba(247, 246, 242, 0.98);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

.nav-inner {
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.brand {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    font-weight: 600;
    color: var(--text-heading);
    text-decoration: none;
    display: flex;
    align-items: center;
}

.brand .italic {
    font-style: italic;
    color: var(--primary);
}

.navbar-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-link {
    color: var(--text-muted);
    font-size: 14px;
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    padding: 8px 0;
    position: relative;
}

.nav-link:hover {
    color: var(--text-primary);
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary);
    transition: width 0.3s ease;
}

.nav-link:hover::after {
    width: 100%;
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
    cursor: pointer;
    font-family: 'Inter', sans-serif;
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
    font-family: 'Inter', sans-serif;
}

.btn-account:hover {
    border-color: var(--text-primary);
    color: var(--text-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.me-1 {
    margin-right: 4px;
}

/* Container for navbar */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .nav-inner {
        height: 60px;
        padding: 10px 0;
    }

    .brand {
        font-size: 22px;
    }

    .navbar-actions {
        gap: 12px;
    }

    .btn-main {
        padding: 8px 16px;
        font-size: 13px;
    }

    .btn-account {
        padding: 6px 12px;
        font-size: 13px;
    }

    .nav-link {
        font-size: 13px;
    }
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.vv-navbar-fixed');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>