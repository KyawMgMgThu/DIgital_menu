<footer class="container shadow-lg">
    <ul class="d-flex justify-content-between mt-2"id="footer-nav">
        <li><a wire:navigate href="{{ route('menu') }}">
                <i class="bi bi-house-door-fill {{ request()->routeIs('menu') ? 'text-primary' : '' }}"></i>
            </a></li>
        <li>
            <a wire:navigate href="{{ route('checkout') }}"><i
                    class="bi bi-cart-fill {{ request()->routeIs('checkout') ? 'text-primary' : '' }} "></i><span
                    class="badge bg-warning text-dark">{{ $total_count }}</span></a>
        </li>
        <li>
            <a href="#"id="scrollToTop"><i class="bi bi-arrow-up-square-fill"></i></a>
        </li>
    </ul>

</footer>
<script>
    const footer = document.querySelector('footer');
    window.onscroll = function() {

        window.scrollY > 80 ? footer.classList.remove('d-none') : footer.classList.add('d-none');
    }
</script>
