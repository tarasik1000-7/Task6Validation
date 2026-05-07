<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Task CRUD')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('owners.index') }}">Task3 CRUD-cars</a>

        <div class="ms-auto d-flex align-items-center gap-2">
            <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm btn-outline-light">EN</a>
            <a href="{{ route('lang.switch', 'it') }}" class="btn btn-sm btn-outline-light">IT</a>

            @auth
                <a class="btn btn-outline-light" href="{{ route('owners.index') }}">
                    {{ __('messages.owners') }}
                </a>

                <a class="btn btn-outline-light" href="{{ route('cars.index') }}">
                    {{ __('messages.cars') }}
                </a>

                <span class="text-white ms-3">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}" class="ms-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm">
                        {{ __('messages.logout') }}
                    </button>
                </form>
            @else
                <a class="btn btn-outline-light" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                <a class="btn btn-outline-light" href="{{ route('register') }}">{{ __('messages.register') }}</a>
            @endauth
        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>