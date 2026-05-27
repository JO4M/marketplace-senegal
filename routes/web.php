<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Seller\SubscriptionController;
use App\Http\Controllers\Buyer\ClaimController as BuyerClaimController;
use App\Http\Controllers\Admin\ClaimController as AdminClaimController;

// Routes publiques
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/produits', [PublicController::class, 'products'])->name('public.products');
Route::get('/produit/{slug}', [PublicController::class, 'show'])->name('public.product.show');
Route::get('/boutique/{id}', [PublicController::class, 'sellerProfile'])->name('public.seller.profile');
// Pages publiques supplémentaires
Route::get('/categories', [PublicController::class, 'categories'])->name('public.categories');
Route::get('/vendeurs', [PublicController::class, 'sellers'])->name('public.sellers');
Route::get('/a-propos', [PublicController::class, 'about'])->name('public.about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes vendeur (protégées par middleware)
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::resource('products', SellerProductController::class);
    Route::post('products/{product}/toggle-status', [SellerProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::delete('products/{product}/delete-photo', [SellerProductController::class, 'deletePhoto'])->name('products.delete-photo');
});

// Routes admin (protégées par middleware)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('vendeurs', \App\Http\Controllers\Admin\VendeurController::class);
    Route::resource('reports', \App\Http\Controllers\Admin\ReportController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('claims', AdminClaimController::class);
    
    Route::post('vendeurs/{id}/approve', [\App\Http\Controllers\Admin\VendeurController::class, 'approve'])->name('vendeurs.approve');
    Route::post('vendeurs/{id}/suspend', [\App\Http\Controllers\Admin\VendeurController::class, 'suspend'])->name('vendeurs.suspend');
    Route::post('reports/{id}/resolve', [\App\Http\Controllers\Admin\ReportController::class, 'resolve'])->name('reports.resolve');
    Route::post('reports/{id}/reject', [\App\Http\Controllers\Admin\ReportController::class, 'reject'])->name('reports.reject');
    Route::post('reports/{id}/suspend-product', [\App\Http\Controllers\Admin\ReportController::class, 'suspendProduct'])->name('reports.suspend-product');
    Route::post('products/{id}/toggle-active', [AdminProductController::class, 'toggleActive'])->name('products.toggle-active');
});

// Routes après connexion selon le rôle
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

// Routes de signalement
Route::middleware(['auth'])->group(function () {
    Route::get('/produit/{id}/signaler', [ReportController::class, 'create'])->name('report.create');
    Route::post('/produit/{id}/signaler', [ReportController::class, 'store'])->name('report.store');
});

// Routes réclamation (acheteur)
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/claims', [BuyerClaimController::class, 'index'])->name('claims.index');
    Route::get('/claims/{id}', [BuyerClaimController::class, 'show'])->name('claims.show');
    Route::get('/claim/product/{id}', [BuyerClaimController::class, 'create'])->name('claim.create');
    Route::post('/claim/product/{id}', [BuyerClaimController::class, 'store'])->name('claim.store');
    Route::get('/dashboard', [App\Http\Controllers\Buyer\DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';