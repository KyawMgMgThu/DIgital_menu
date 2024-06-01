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

    <!-- ======= Book A Table Section ======= -->
    <section id="book-a-table" class="book-a-table">
        <div class="container max-width-container">
            <div class="section-title">
                <h2>Book a <span>Menu</span></h2>
            </div>

            <div class="checkout-container">
                <div class="table-responsive">
                    <table id="cart" class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart_items as $item)
                                <tr wire:key="{{ $item['product_id'] }}">
                                    <td><img src="{{ url('storage', $item['image']) }}" alt="{{ $item['name'] }}"
                                            class="img-fluid"
                                            style="max-width: 100px; max-height: 50px;">{{ $item['name'] }}</td>
                                    <td>{{ $item['unit_amount'] }} Ks</td>
                                    <td>
                                        <div class="quantity-input">
                                            <button class="btn btn-quantity" type="button"
                                                wire:click="decreaseQty({{ $item['product_id'] }})">-</button>
                                            <input type="text" class="quantity-display"
                                                value="{{ $item['quantity'] }}" readonly>
                                            <button class="btn btn-quantity" type="button"
                                                wire:click="increaseQty({{ $item['product_id'] }})">+</button>
                                        </div>
                                    </td>

                                    <td>{{ number_format($item['quantity'] * $item['unit_amount'], 2) }} Ks</td>
                                    <td>
                                        <div class="btn btn-close mb-3 ms-5"
                                            wire:click="removeFromCart({{ $item['product_id'] }})">
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No items in the cart</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <form role="form" class="email-form" wire:submit.prevent='placeOrder'>
                <div class="row">
                    <div class="form-group mt-3">
                        <div class="total">
                            <h3>စုစုပေါင်းကျငွေ <span id="total-amount">{{ number_format($grant_total, 2) }} Ks</span>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 form-group">
                        <select class="form-select form-select-sm mt-3 p-2" wire:model='table_no'
                            aria-label=".form-select-sm">
                            <option selected>စားပွဲနံပါတ်ရွေးရန်</option>
                            <option value="1">စားပွဲနံပါတ် ၁</option>
                            <option value="2">စားပွဲနံပါတ် ၂</option>
                            <option value="3">စားပွဲနံပါတ် ၃</option>
                            <option value="4">စားပွဲနံပါတ် ၄</option>
                            <option value="5">စားပွဲနံပါတ် ၅</option>
                        </select>
                    </div>
                    <div class="mt-3 mb-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" wire:model='status' type="radio" name="inlineRadioOptions"
                                id="inlineRadio1" value="ပါဆယ်">
                            <label class="form-check-label" for="inlineRadio1">ပါဆယ်</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" wire:model='status' type="radio" name="inlineRadioOptions"
                                id="inlineRadio2" value="ဆိုင်ထိုင်">
                            <label class="form-check-label" for="inlineRadio2">ဆိုင်ထိုင်</label>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-6">
                            <a href="{{ route('home') }}">
                                <button type="button" class="btn btn-warning">ထပ်ဝယ်မည်</button>
                            </a>
                        </div>
                        @if ($cart_items)
                            <div class="col-4">
                                <button type="submit" class="btn btn-warning"
                                    wire:click="addToCart(product_id)">မှာမည်</button>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- End Book A Table Section -->
</div>
