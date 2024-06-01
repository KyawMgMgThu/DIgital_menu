<div>
    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center fixed-top topbar-transparent">
        <div
            class="container-fluid container-xl d-flex align-items-center justify-content-center justify-content-lg-start">
            <i class="bi bi-phone d-flex align-items-center"><span>+959 662988841</span></i>
            <i class="bi bi-clock ms-4 d-none d-lg-flex align-items-center"><span>Mon-Sun: 06:00 AM - 08:00 PM</span></i>
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <div class="logo me-auto">
                <h1><a href="{{ route('home') }}">Digital Menu</a></h1>
            </div>

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto" href="{{ route('home') }}">Home</a></li>
                    <li><a class="nav-link scrollto" href="#menu">Menu</a></li>
                    <li><a wire:navigate href="{{ route('checkout') }}" class="nav-link scrollto">
                            Book a Menu
                        </a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->
    <a wire:navigate href="{{ route('checkout') }}" class="back-to-top">
        <i class="bi bi-cart-fill">
            <span class="badge text-dark">{{ $total_count }}</span>
        </i>
    </a>
</div>
