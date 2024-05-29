<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Footer;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;


#[Title('Home Page - Digital Menu  ')]

class HomePage extends Component
{
    use LivewireAlert;
    #[Url]
    public $selected_categories = [];


    //add product to cart
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'မှာယူဖို့အတွက် ဈေးခြင်းထဲထည့်ခြင်း အောင်မြင်ပါသည်', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']);

        $productsQuery = Product::query()->where('is_active', 1);

        if (!empty($this->selected_categories)) {
            $productsQuery->whereIn('category_id', $this->selected_categories);
        }

        $products = $productsQuery->get();
        return view('livewire.home-page', compact('categories', 'products'));
    }
}
