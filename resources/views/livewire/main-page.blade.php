<!-- menu-start -->
<div class="container pb-5 mb-3">
    <div class="menu-title pt-3">
        <ul class="d-flex flex-row flex-wrap">
            @foreach ($categories as $category)
                <li class="nav-item active me-3" wire:key="{{ $category->id }}">
                    <label for="{{ $category->slug }}">
                        <input type="checkbox" wire:model.live="selected_categories" id="{{ $category->id }}"
                            value="{{ $category->id }}">
                        <span class="text-lg">{{ $category->name }}</span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
    @foreach ($products as $product)
        <div class="card mt-4 "data-aos="fade-up" data-aos-once="true" data-aos-duration="1500">
            <div class="row g-0">
                <div class="col-6">
                    <img src="{{ url('storage', $product->images) }}" class="rounded" alt="{{ $product->name }}">
                </div>
                <div class="col-6">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-price pt-2 ">{{ $product->price }}Ks</p>
                        <a wire:click.prevent="addToCart({{ $product->id }})" type="button"
                            class="btn btn-warning"><span wire:loading.remove
                                wire:target='addToCart({{ $product->id }})'>မှာယူမည်</span><span wire:loading
                                wire:target='addToCart({{ $product->id }})'>Loading...</span></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- menu-end -->
