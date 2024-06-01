<div>
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="hero-container max-width-container">
            <div class="carousel carousel-fade">
                <ol class="carousel-indicators"></ol>

                <div class="">
                    <!-- Slide 1 -->
                    <div class="carousel-item active" style="background-image: url(assets/img/slide/images.png)">
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2 class="animate__animated animate__fadeInDown">
                                    <span>Kyaw Gyi & Zar Ni</span> Restaurant
                                </h2>
                                <div>
                                    <a href="#menu" class="btn-menu animate__animated animate__fadeInUp scrollto">Our
                                        Menu</a>
                                    <a href="{{ route('checkout') }}"
                                        class="btn-book animate__animated animate__fadeInUp scrollto">Book a Menu</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">
        <!-- start menu Section -->

        <section id="menu" class="menu section-bg">
            <div class="container max-width-container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Menu</h2>
                    <p>Check Our Tasty Menu</p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 justify-content-center">
                        <ul class="d-flex flex-wrap justify-content-center list-unstyled">
                            @foreach ($categories as $category)
                                <li class="nav-item active me-3 " wire:key="{{ $category->id }}">
                                    <label for="{{ $category->slug }}">
                                        <input type="checkbox" wire:model.live="selected_categories"
                                            id="{{ $category->id }}" value="{{ $category->id }}">
                                        <span class="text-lg">{{ $category->name }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($products as $product)
                        <div class="col-lg-6 menu-item filter-drinks">
                            @if (is_array($product->images) && count($product->images) > 0)
                                <img src="{{ Storage::url($product->images[0]) }}" class="menu-img"
                                    alt="{{ $product->name }}" />
                            @else
                                <img src="{{ Storage::url($product->images) }}" class="menu-img"
                                    alt="{{ $product->name }}" />
                            @endif
                            <div class="menu-item-details">
                                <div class="menu-content">
                                    <a href="#"> {{ $product->name }}</a><span>{{ $product->price }}Ks</span>
                                </div>
                                <div>
                                    <a wire:click.prevent="addToCart({{ $product->id }})" type="button"
                                        class="btn btn-warning"><span wire:loading.remove
                                            wire:target='addToCart({{ $product->id }})'>မှာယူမည်</span><span
                                            wire:loading
                                            wire:target='addToCart({{ $product->id }})'>Loading...</span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <!-- End Menu Section -->
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container mt-5 max-width-container">
                <div class="section-title">
                    <h2><span>Contact</span> Us</h2>
                    <p>Show Our Details</p>
                </div>
                <div class="info-wrap">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 info">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>Myay Ni Road <br />Mergui</p>
                        </div>

                        <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
                            <i class="bi bi-clock"></i>
                            <h4>Open Hours:</h4>
                            <p>Monday-Sunday:<br />06:00 AM - 08:00 PM</p>
                        </div>

                        <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>mthu35997@gmail.com</p>
                        </div>

                        <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>+959 662988841</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Section -->
    </main>
    <!-- End #main -->
</div>
