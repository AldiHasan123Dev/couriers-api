
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Courier Management') | CourierHub</title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    {{-- CSS aplikasi --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>

<body>
    <div class="d-flex main-layout">
        <aside class="app-sidebar p-3">
            <a href="{{ route('couriers.index') }}"
               class="d-flex align-items-center gap-3 text-decoration-none text-dark mb-4 px-2">
                <span class="brand-mark">
                    <i class="bi bi-box-seam"></i>
                </span>

                <span>
                    <strong class="d-block fs-5">CourierHub</strong>
                    <small class="text-muted-custom">Management System</small>
                </span>
            </a>

            <small class="text-muted-custom text-uppercase fw-semibold px-3">
                Menu utama
            </small>

            <nav class="sidebar-navigation mt-3">
                <a href="{{ route('couriers.index') }}"
                   class="sidebar-link {{ request()->routeIs('couriers.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    Data Kurir
            </a>
            </nav>

            <div class="mt-5 p-3 rounded-3" style="background:#f5f7fb">
                <div class="fw-semibold mb-1">CourierHub</div>
                <small class="text-muted-custom">
                    Sistem pengelolaan master data kurir.
                </small>
            </div>
        </aside>

        <div class="flex-grow-1 min-vh-100">
            <header class="topbar d-flex align-items-center justify-content-between px-4 px-lg-5">
                <div>
                    <div class="fw-semibold">@yield('page-heading', 'Data Kurir')</div>
                    <small class="text-muted-custom">Master Data / Courier</small>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="avatar">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="d-none d-sm-block">
                        <div class="fw-semibold">Administrator</div>
                        <small class="text-muted-custom">Pengelola sistem</small>
                    </div>
                </div>
            </header>

            <main class="page-content p-4 p-lg-5">
                @include('components.alert')

                @yield('content')

                <footer class="mt-5 pt-3 border-top text-muted-custom small">
                    &copy; {{ date('Y') }} CourierHub. Courier Management System.
                </footer>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
