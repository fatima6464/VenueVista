<style>
    /* Force reset for Admin View */
    body { padding-top: 0 !important; background-color: #f8fafc; }

    /* Single Professional Header */
    .admin-single-header {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 1050;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .admin-brand {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        color: #1c2b25 !important;
        text-decoration: none;
    }
    .admin-brand .italic { font-style: italic; color: var(--primary); }

    /* Navigation Links inside Header */
    .header-nav {
        display: flex;
        gap: 20px;
        margin-left: 40px;
        border-left: 1px solid #eee;
        padding-left: 40px;
    }
    .header-nav-link {
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: 0.3s;
    }
    .header-nav-link:hover, .header-nav-link.active { color: var(--primary); }
    .header-nav-link.active { font-weight: 700; }

    .btn-logout {
        color: #e11d48;
        background: #fff1f2;
        border: 1px solid #fda4af;
        padding: 6px 16px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-logout:hover { background: #e11d48; color: white !important; }

    /* Layout Spacing */
    .admin-content { padding-top: 40px; }
    .stat-card { transition: all 0.3s ease; border-radius: 12px; border: none !important; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: var(--shadow) !important; }
</style>

<header class="admin-single-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="/" class="admin-brand">
                    Venue<span class="italic">Vista</span>
                </a>

                <nav class="header-nav d-none d-lg-flex">
                    <a href="/admin/dashboard" class="header-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="/admin/venues" class="header-nav-link {{ request()->is('admin/venues') ? 'active' : '' }}">Venues</a>
                    <a href="/admin/venues/add" class="header-nav-link {{ request()->is('admin/venues/add') ? 'active' : '' }}">Add Venue</a>
                    <a href="/admin/bookings" class="header-nav-link {{ request()->is('admin/bookings') ? 'active' : '' }}">Bookings</a>
                </nav>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="text-end d-none d-md-block">
                    <div class="small fw-bold text-dark">{{ $user->name }}</div>
                    <div class="text-muted" style="font-size: 11px;">Administrator</div>
                </div>
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-power-off me-2"></i>Logout
                </a>
            </div>
        </div>
    </div>
</header>