<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;


#[Title('Home Page - Digital Menu  ')]

class HomePage extends Component
{

    public function render()
    {
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug', 'image']);
        return view('livewire.home-page', compact('categories'));
    }
}
