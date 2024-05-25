<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Menu Page - Digital Menu ')]
class MainPage extends Component
{
    #[Url]
    public $selected_categories = [];

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
