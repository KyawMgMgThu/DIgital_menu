<div>
    <div class="container pt-3" style="height: 50px;">
        <div class="row">
            <div class="col-1"><a href="{{ route('menu') }}" id="one" class="flex-grow-0"><i
                        class="bi bi-arrow-left-circle-fill"></i></a></div>
            <div class="col-7">
                <h5 class="text-center">စျေးခြင်းတောင်း</h5>
            </div>
            <div class="col-4">
                <h5 class="show-footer text-center" id="calc">တွက်မည်</h5>
            </div>
        </div>
        <div class="content-items">
            @forelse ($cart_items as $item)
                <div class="row mt-4" wire:key="{{ $item['product_id'] }}">
                    <div class="col-4">
                        <img src="{{ url('storage', $item['image']) }}" alt="{{ $item['name'] }}"
                            class="w-100 h-100 img-fluid rounded">
                    </div>
                    <div class="col-5">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <div class="d-flex">
                            <p class="card-price pt-2">{{ $item['unit_amount'] }}Ks x {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                    <div class="col-3 d-flex flex-column">
                        <div class="btn btn-close mb-3 ms-5" wire:click="removeFromCart({{ $item['product_id'] }})">
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <button class="w-auto h-100 bg-warning text-dark rounded outline-none cursor-pointer">
                                <div class="btn btn-sm btn-warning" wire:click="decreaseQty({{ $item['product_id'] }})">
                                    -</div>
                            </button>

                            <div wire:model="quantity" class="x-2" min="1">
                                {{ $item['quantity'] }}</div>
                            <button class="w-auto h-100 bg-warning text-dark rounded outline-none cursor-pointer">
                                <div class="btn btn-sm show-footer"
                                    wire:click="increaseQty({{ $item['product_id'] }})">
                                    +</div>
                            </button>

                        </div>
                    </div>
                </div>
            @empty
                <div class="row mt-4">No items available in cart!</div>
            @endforelse
        </div>
    </div>

    <form wire:submit.prevent='placeOrder'>
        <div class="container-fluid border mb-5 d-none" id="footer">

            <div class="row mt-3">
                <div class="col-8">
                    <div class="total-price">စုစုပေါင်းကျငွေ</div>
                </div>
                <div class="col-4">
                    <div class="card-price">{{ number_format($grant_total, 2) }}Ks</div>
                </div>
            </div>

            <select class="form-select form-select-sm mt-3 p-2" wire:model='table_no' aria-label=".form-select-sm">
                <option selected>စားပွဲနံပါတ်ရွေးရန်</option>
                <option value="1">စားပွဲနံပါတ် ၁</option>
                <option value="2">စားပွဲနံပါတ် ၂</option>
                <option value="3">စားပွဲနံပါတ် ၃</option>
                <option value="4">စားပွဲနံပါတ် ၄</option>
                <option value="5">စားပွဲနံပါတ် ၅</option>
            </select>

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
                    <a href="{{ route('menu') }}">
                        <button type="button" class="btn btn-warning">ထပ်ဝယ်မည်</button>
                    </a>
                </div>
                @if ($cart_items)
                    <div class="col-6">
                        <button type="submit" class="btn btn-warning"
                            wire:click="addToCart(product_id)">မှာမည်</button>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
