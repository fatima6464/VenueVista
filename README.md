# 🏛️ VenueVista

![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777bb4.svg)
![Status](https://img.shields.io/badge/Status-Academic%20Project-brightgreen.svg)

A full-stack **venue booking platform** built with **Laravel**, allowing users to browse and book event venues while admins manage venue listings and bookings through a dedicated dashboard. Built as a **Web Development** course project.

---

## 📋 Overview

VenueVista lets registered users discover venues (by capacity, location, amenities, and hourly pricing), book them for a specific date and time slot, and track their bookings. Admins get a separate role-gated dashboard to add/edit/delete venues, manage image galleries, toggle availability, and confirm or cancel bookings.

## ✨ Features

- 🔐 **Role-Based Authentication** — separate `is_admin` / `is_user` middleware gating admin and user areas
- 🏢 **Venue Management (Admin)** — add, edit, delete venues; manage venue images; toggle availability
- 📅 **Venue Booking (User)** — browse venues, view details, book a date/time slot, view booking history, cancel bookings
- ✅ **Booking Workflow** — bookings can be confirmed or cancelled by an admin
- 🧮 **Computed Attributes** — human-readable booking reference codes (e.g. `BK000123`) and structured operating-hours/main-image accessors on the `Venue` model
- 🖼️ **Image Uploads** — venues support multiple images with individual delete support

## 🛠️ Tech Stack

| Category | Details |
|---|---|
| Framework | Laravel 12 (PHP 8.2+) |
| Database | SQLite (default, configurable via `.env`) |
| Templating | Blade |
| Auth | Custom `AuthController` with role-based middleware (`IsAdmin`, `IsUser`) |
| Testing | PHPUnit |

## 📁 Project Structure

```
VenueVista/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/AdminController.php    # Venue & booking management
│   │   │   ├── User/UserController.php      # Browsing & booking
│   │   │   ├── AuthController.php           # Login/register/logout
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       ├── IsAdmin.php
│   │       ├── IsUser.php
│   │       └── ShareViewData.php
│   └── Models/
│       ├── User.php
│       ├── Venue.php
│       └── Booking.php
├── database/
│   ├── migrations/       # users, venues, bookings tables
│   ├── factories/
│   └── seeders/
├── resources/views/
│   ├── admin/            # dashboard, venues, add/edit-venue, bookings
│   ├── user/             # dashboard, venues, venue-details, book-venue, my-bookings
│   ├── auth/             # login, register
│   └── partials/         # header, footer, admin-header
├── routes/web.php
├── config/venuevista.php # admin credential env mapping
└── README.md
```

## ⚙️ Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/<your-username>/VenueVista.git
   cd VenueVista
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy the environment file and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Set up the database (SQLite by default):
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```
5. Serve the application:
   ```bash
   php artisan serve
   ```
6. Visit `http://localhost:8000`

## 🗄️ Database Schema

- **users** — includes a `role` column distinguishing admins from regular users
- **venues** — name, description, capacity, location, amenities (array), price per hour, images (array), availability flag, operating hours, creator reference
- **bookings** — linked to a user and a venue, with date, start/end time, total hours, total amount, and status

## 🔑 Default Admin Access

Admin credentials default to `admin@venue.com` / `admin123` (overridable via `ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env`, see `config/venuevista.php`).

> ⚠️ **Security note:** Change these before deploying anywhere beyond local development.

## 📚 What I Learned

- Implementing role-based access control in Laravel via custom middleware (`IsAdmin`, `IsUser`)
- Structuring a two-sided (admin/user) application within a single Laravel app using route groups and prefixes
- Modeling a booking system with derived/computed Eloquent attributes (booking reference codes, operating-hours accessors)
- Handling image uploads and array-cast JSON columns (`amenities`, `images`) in Eloquent
- Working with Laravel's migration and seeder system to structure a relational schema

## 🔮 Future Improvements

- Payment gateway integration for booking confirmation
- Email notifications for booking confirmation/cancellation
- Search and filtering by location, price range, and capacity
- Calendar view for venue availability

## 🎓 Course

Web Development — BS Computer Science

## 👩‍💻 Author

**Fatima Nadeem**
BS Computer Science

## 📎 Notes

- `vendor/`, `.env`, and local database/cache files are excluded from version control (see `.gitignore`)
- Run `composer install` after cloning to regenerate the `vendor/` directory
