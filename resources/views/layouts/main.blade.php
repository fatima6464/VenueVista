<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Venue Management System' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

@php
    // Mirrors the EJS logic that decides whether to hide the navbar/footer
    $path = strtolower($currentPath ?? '');
    $pageTitle = strtolower($title ?? '');

    $isAuthPage = str_contains($path, 'login')
        || str_contains($path, 'register')
        || str_contains($pageTitle, 'login')
        || str_contains($pageTitle, 'register');

    $isAdminArea = str_contains($path, 'admin');

    $shouldHide = ($hideNavbar ?? false) || ($hideFooter ?? false) || $isAuthPage || $isAdminArea;
@endphp

<body style="{{ $shouldHide ? 'padding-top: 0 !important;' : '' }}">

    @unless($shouldHide)
        @include('partials.header')
    @endunless

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    @unless($shouldHide)
        @include('partials.footer')
    @endunless

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>