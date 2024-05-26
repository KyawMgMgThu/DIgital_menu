<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Footer;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Checkout Page -Digital Menu')]
class CheckoutPage extends Component
{
    use LivewireAlert;
    public $cart_items = [];
    public $grant_total;

    public $quantity = 1;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookies();
        $this->grant_total = CartManagement::calculateCartTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Footer::class);
    }

    public function removeFromCart($product_id)
    {

        $this->cart_items = CartManagement::removeItemFromCart($product_id);
        $this->grant_total = CartManagement::calculateCartTotal($this->cart_items);
    }

    public function increaseQty()
    {
        $this->quantity += 1;
    }
    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity -= 1;
        }
    }
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);
        $this->alert('success', 'မှာယူခြင်း အောင်မြင်ပါသည်', [
            'position' => 'top-start',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    public function render()
    {
        return view('livewire.checkout-page');
    }
}
