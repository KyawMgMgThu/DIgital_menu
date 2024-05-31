<?php

use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Dompdf\Dompdf;

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
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/orders/{order}/download-pdf', function (Order $order) {
    $dompdf = new Dompdf();
    $html = view('pdf.order', compact('order'))->render();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    return $dompdf->stream('order.pdf');
})->name('download.order.pdf')->middleware('signed');
