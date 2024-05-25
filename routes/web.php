<?php

use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MainPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomePage::class)->name('home');
Route::get('/menu', MainPage::class)->name('menu');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
