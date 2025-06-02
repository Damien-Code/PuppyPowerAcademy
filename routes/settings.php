<?php

use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminTrainingCategoryController;
use App\Http\Controllers\Admin\AdminTrainingController;
use App\Http\Controllers\Admin\AdminWebshopController;
use App\Http\Controllers\Admin\AdminDaycareController;
use App\Http\Controllers\Settings\OrderHistoryController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TrainingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::resource('settings/training', TrainingController::class);

    Route::post('settings/trainings/{training}/mark-watched', [TrainingController::class, 'markWatched'])
        ->name('trainings.markWatched');

    Route::resource('settings/order-history', OrderHistoryController::class);

    // Extra middleware grouping for admin
    // Defining these grouped routes will result in attempt to read role_id on null
    // This is because it isn't asking for auth
    Route::middleware('admin')->group(function () {
        
        Route::get('settings/admin/training', function () {
            return Inertia::render('settings/admin/Training');
        })->name('admin.training');


        //Group for admin because it would interfere with webshop routes from webshop and admin_webshop
        Route::name('admin.')->group(function () {
            Route::resource('settings/admin/contact', AdminContactMessageController::class);
            Route::resource('settings/admin/dagopvang', AdminDaycareController::class);

            Route::resource('settings/admin/webshop', AdminWebshopController::class)->parameters(['webshop' => 'product']);
            Route::resource('settings/admin/training', AdminTrainingController::class);
            Route::resource('settings/admin/training-categories', AdminTrainingCategoryController::class);
        });
    });
});
