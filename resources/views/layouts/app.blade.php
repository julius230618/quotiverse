<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Qoutiverse') · Qoutiverse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/quotiverse.css') }}" rel="stylesheet">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-mark"><i class="bi bi-quote"></i></span>
                <span class="brand-copy">
                    <span class="brand-name">Qoutiverse</span>
                    <span class="brand-tagline">A little universe of words and inspiration.</span>
                </span>
                <i class="bi bi-stars brand-sparkle" aria-hidden="true"></i>
            </a>
            <div class="sidebar-label">Workspace</div>
            <nav class="nav flex-column gap-1">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
                <a class="nav-link {{ request()->routeIs('quotes.*') ? 'active' : '' }}" href="{{ route('quotes.index') }}"><i class="bi bi-chat-square-quote"></i> All quotes</a>
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"><i class="bi bi-tags"></i> Categories</a>
            </nav>
            <div class="sidebar-note">
                <div class="note-icon"><i class="bi bi-stars"></i></div>
                <strong>A little inspiration</strong>
                <p>Keep the words that move you close.</p>
            </div>
            <div class="sidebar-footer">Your personal quote journal</div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="topbar-caption">YOUR LITTLE CORNER OF INSPIRATION</div>
                <a class="btn btn-primary btn-sm topbar-action" href="{{ route('quotes.create') }}"><i class="bi bi-plus-lg"></i> New quote</a>
            </header>
            <div class="page-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Please check the form and try again.</strong>
                        <ul class="mb-0 mt-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
