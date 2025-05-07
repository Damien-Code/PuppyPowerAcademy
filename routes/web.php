<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('dashboard');

Route::get('webshop', function () {
    return Inertia::render('webshop/Index');
})->name('webshop/Index');

Route::get('webshop/{id}', function () {
    return Inertia::render('webshop/Show');
})->name('webshop.show');

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
