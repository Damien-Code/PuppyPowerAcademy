<?php

use App\Http\Controllers\Settings\OrderHistoryController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');

//    Route::get('settings/order-history', function () {
//        return Inertia::render('settings/OrderHistory');
//    })->name('order-history');

//    Route::get('settings/order-history', [OrderHistoryController::class, 'index'])->name('order-history');
    Route::resource('settings/order-history', OrderHistoryController::class);
});

Route::middleware('admin')->group(function () {
    Route::get('settings/admin/webshop', function () {
        return Inertia::render('settings/admin/Webshop');
    })->name('admin.webshop');

    Route::get('settings/admin/dagopvang', function () {
        return Inertia::render('settings/admin/Dagopvang');
    })->name('admin.dagopvang');

    Route::get('settings/admin/training', function () {
        return Inertia::render('settings/admin/Training');
    })->name('admin.training');

    Route::resource('settings/admin/contact', AdminContactController::class);
});
