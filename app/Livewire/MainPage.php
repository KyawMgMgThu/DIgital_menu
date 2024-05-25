<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Footer;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Menu Page - Digital Menu ')]
class MainPage extends Component
{
    use LivewireAlert;
    #[Url]
    public $selected_categories = [];

    //add product to cart
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Footer::class);
        $this->alert('success', 'မှာယူဖို့အတွက် ဈေးခြင်းထဲထည့်ခြင်း အောင်မြင်ပါသည်', [
            'position' => 'top-start',
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

        return view('livewire.main-page', compact('products', 'categories'));
    }
}
