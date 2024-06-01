<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Footer;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Psy\VersionUpdater\Checker;

#[Title('Checkout Page - Digital Menu')]
class CheckoutPage extends Component
{
    use LivewireAlert;

    public $cart_items = [];
    public $grant_total;
    public $quantity = 1;
    public $table_no;
    public $payment_method;
    public $payment_status;
    public $status = 'ဆိုင်ထိုင်';

    public function placeOrder()
    {
        $this->validate([
            'table_no' => 'required_if:status,==,ဆိုင်ထိုင်',
            'status' => 'required|in:ဆိုင်ထိုင်,ပါဆယ်',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookies();
        $line_items = [];

        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                ],
            ];
        }

        $order = new Order();
        $order->grand_total = CartManagement::calculateCartTotal($cart_items);
        $order->payment_method = 'cash';
        $order->payment_status = 'pending';
        $order->status = $this->status;
        $order->table_no = $this->status == 'ဆိုင်ထိုင်' ? $this->table_no : 'none';

        $redirect_url = route('home');
        $order->save();
        $order->item()->createMany($cart_items);
        CartManagement::removeCartItemsFromCookies();
        $this->alert('success', 'မှာယူခြင်း အောင်မြင်ပါသည်', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);

        return redirect($redirect_url);
    }

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
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
    }

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementCartItemToQuantity($product_id);
        $this->grant_total = CartManagement::calculateCartTotal($this->cart_items);
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementCartItemToQuantity($product_id);
        $this->grant_total = CartManagement::calculateCartTotal($this->cart_items);
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookies();
        $grant_total = CartManagement::calculateCartTotal($cart_items);
        return view('livewire.checkout-page', compact('cart_items', 'grant_total'));
    }
}
