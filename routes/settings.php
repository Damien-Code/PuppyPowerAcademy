<?php

use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminWebshopController;
use App\Http\Controllers\Settings\OrderHistoryController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\WebshopController;
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

    Route::resource('settings/order-history', OrderHistoryController::class);

    // Extra middleware grouping for admin
    // Defining these grouped routes will result in attempt to read role_id on null
    // This is because it isn't asking for auth
    Route::middleware('admin')->group(function () {
        Route::get('settings/admin/dagopvang', function () {
            return Inertia::render('settings/admin/Dagopvang');
        })->name('admin.dagopvang');

        Route::get('settings/admin/training', function () {
            return Inertia::render('settings/admin/Training');
        })->name('admin.training');

        Route::name('admin.')->group(function () {
            Route::resource('settings/admin/webshop', AdminWebshopController::class)->parameters(['webshop' => 'product']);
        });

        Route::resource('settings/admin/contact', AdminContactController::class);
    });
});
