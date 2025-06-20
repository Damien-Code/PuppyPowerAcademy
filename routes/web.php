<?php


use App\Http\Controllers\CartController;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DaycareController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WebshopController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware('auth')->name('dashboard');

Route::resource('webshop', WebshopController::class, ['parameters' => [
    'webshop' => 'product'
]]);
Route::resource('training', TrainingController::class);

Route::delete('cart/deleteAllItems', [CartController::class, 'destroy'])
->middleware('auth')->name('cart.destroy');

Route::resource('cart', CartController::class)->middleware('auth')->except(['destroy']);


//Route::get('dagopvang', function () {
//    return Inertia::render('dagopvang/Index');
//})->name('dagopvang/Index');

Route::resource('dagopvang', DaycareController::class)->except(['index'])->middleware('auth');

Route::get('dagopvang', [DaycareController::class, 'index'])->name('dagopvang.index');



Route::get('dagopvang/planning', function () {
    return Inertia::render('dagopvang/Planning');
})->name('dagopvang.planning')->middleware('auth');

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('about', function () {
    return Inertia::render('About');
})->name('about');

Route::resource('contact', ContactController::class);

// If route does not exist, return to home
Route::fallback(function () {
    return redirect()->route('home');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
