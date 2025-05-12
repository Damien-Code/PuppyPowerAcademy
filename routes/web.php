<?php

use App\Http\Controllers\WebshopController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('dashboard');

// Route::post('webshop', [WebshopController::class,'store'])->name('webshop');
Route::resource('webshop', WebshopController::class, ['parameters' => [
    'webshop' => 'product'
]]);


Route::get('webshop/cart', function () {
    return Inertia::render('webshop/Cart');
})->name('webshop.cart')->middleware('auth');


Route::get('training', function () {
    return Inertia::render('training/Index');
})->name('training/Index');

Route::get('dagopvang', function () {
    return Inertia::render('dagopvang/Index');
})->name('dagopvang/Index');

Route::get('dagopvang/planning', function () {
    return Inertia::render('dagopvang/Planning');
})->name('dagopvang.planning')->middleware('auth');

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('contact', function () {
    return Inertia::render('Contact');
})->name('contact');




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
