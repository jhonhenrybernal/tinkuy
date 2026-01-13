<?php

use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Vendor\Auth\AuthController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\ProductReviewController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\SocialMediaLinkController;
use App\Http\Controllers\Vendor\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('vendor')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('/login', [AuthController::class, 'login'])->name('vendor.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.vendor')->name('vendor.logout');

    Route::middleware('auth.vendor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('vendor.dashboard');
        Route::resource('products', ProductController::class)->names('vendor.products');
        Route::post('products/data', [ProductController::class, 'getProducts'])->name('vendor.products.data');
        Route::post('products/updateStatus', [ProductController::class, 'updateStatus'])->name('vendor.products.updateStatus');
        Route::resource('social-media-links', SocialMediaLinkController::class)->names('vendor.social-media-links');
        Route::post('social-media-links/data', [SocialMediaLinkController::class, 'getData'])->name('vendor.social-media-links.data');

        Route::get('reviews', [ProductReviewController::class, 'index'])->name('vendor.reviews.index');
        Route::get('reviews/data', [ProductReviewController::class, 'getData'])->name('vendor.reviews.data');
        Route::get('reviews/{review}', [ProductReviewController::class, 'show'])->name('vendor.reviews.show');
        Route::delete('reviews/{review}', [ProductReviewController::class, 'destroy'])->name('vendor.reviews.destroy');

        /** Orders */
        Route::get('orders', [OrderController::class, 'index'])->name('vendor.orders.index');
        Route::post('orders/data', [OrderController::class, 'getData'])->name('vendor.orders.data');
        Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('vendor.orders.destroy');

        /** Language Switch */
        Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('vendor.change.language');

        /** Profile */
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('vendor.profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('vendor.profile.update');

        Route::get('business/settings', [SettingsController::class, 'index'])->name('vendor.business.settings.edit');
        Route::put('business/settings/{id}', [SettingsController::class, 'update'])->name('vendor.business.settings.update');
        Route::get('validation/catalog', [SettingsController::class, 'adminValidationCatalog'])->name('vendor.validation.catalog');

        Route::post('validation/reasons', [SettingsController::class, 'adminValidationReasonStore'])->name('vendor.validation.reasons.store');

        Route::put('validation/reasons/{id}', [SettingsController::class, 'adminValidationReasonUpdate'])->name('vendor.validation.reasons.update');

        Route::get('vendor/template-preview/{pageType}', [SettingsController::class, 'templatePreview'])->name('vendor.template-preview');
        Route::post('vendor/resize-media', [SettingsController::class, 'resizeMedia'])->name('vendor.resize-media');
    });
});
