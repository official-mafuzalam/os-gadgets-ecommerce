<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\HomeController as PublicHomeController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\SearchController;
use Illuminate\Support\Facades\Artisan;


Route::get('/session', function () {
    $session = session()->all();
    dd($session);
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('optimize:clear');
    return to_route('public.welcome')->with('success', 'Cache cleared successfully! ' . $exitCode);
})->name('clear.cache');


// For all public pages -->

Route::get('/', [PublicHomeController::class, 'index'])->name('public.welcome');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('public.search');
Route::get('/search/live', [SearchController::class, 'liveSearch'])->name('public.search.live');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('public.cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('public.products.buy-now');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('public.checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('public.checkout.process');
Route::get('/order-complete', [CheckoutController::class, 'orderComplete'])->name('public.order.complete');
Route::get('/track-parcel', [CheckoutController::class, 'orderTrack'])->name('public.parcel.tracking');
Route::post('/track-parcel', [CheckoutController::class, 'track'])->name('public.parcel.tracking.submit');

Route::get('/products', [PublicProductController::class, 'products'])->name('public.products');
Route::get('/product/{product}', [PublicProductController::class, 'productShow'])->name('public.products.show');
Route::get('/brands', [PublicProductController::class, 'brands'])->name('public.brands');
Route::get('/brands/{brand}', [PublicProductController::class, 'brandShow'])->name('public.brands.show');
Route::get('/categories', [PublicProductController::class, 'categories'])->name('public.categories');
Route::get('/categories/{category}', [PublicProductController::class, 'categoryShow'])->name('public.categories.show');
Route::get('/featured-products', [PublicProductController::class, 'featuredProducts'])->name('public.featured.products');
Route::get('/deals', [PublicProductController::class, 'deals'])->name('public.deals');
Route::get('/deals/{deal}', [PublicProductController::class, 'dealShow'])->name('public.deals.show');

Route::post('/products/{product}/review', [PublicProductController::class, 'submitReview'])->name('public.products.review.submit');

// Static Pages
Route::get('/about', [PublicHomeController::class, 'about'])->name('public.about');
Route::get('/contact', [PublicHomeController::class, 'contact'])->name('public.contact');
Route::post('/contact', [PublicHomeController::class, 'submitContact'])->name('public.contact.submit');
Route::post('/subscribe', [PublicHomeController::class, 'subscribe'])->name('public.subscribe');
Route::get('/privacy-policy', [PublicHomeController::class, 'privacyPolicy'])->name('public.privacy-policy');
Route::get('/terms-of-service', [PublicHomeController::class, 'termsOfService'])->name('public.terms-of-service');
Route::get('/return-policy', [PublicHomeController::class, 'returnPolicy'])->name('public.return-policy');


// AI Product Description Generator
Route::post('/generate-description', [ProductController::class, 'generateDescription']);

// For all auth user
Route::middleware(['auth', 'role:super_admin|admin|user'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('admin.index');

        // Admin Order Routes
        Route::prefix('/orders')->name('admin.orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('/{id}', [OrderController::class, 'update'])->name('update');
            Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::patch('/{id}/mark-paid', [OrderController::class, 'markAsPaid'])->name('mark-paid');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        });

        // Invoice routes
        Route::prefix('/orders/{order}/invoice')->name('admin.orders.invoice.')->group(function () {
            Route::get('/pdf', [OrderController::class, 'downloadInvoice'])->name('pdf');
            Route::get('/email', [OrderController::class, 'emailInvoice'])->name('email');
        });

        Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('admin.reports.sales');

        Route::resource('products', ProductController::class)->names('admin.products');
        Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');
        Route::patch('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('admin.products.toggle-featured');
        Route::post('products/{product}/set-primary-image', [ProductController::class, 'setPrimaryImage'])->name('admin.products.set-primary-image');

        Route::get('{product}/deals', [ProductController::class, 'editDeals'])->name('admin.products.deals.edit');
        Route::post('{product}/deals/assign', [ProductController::class, 'assignDeals'])->name('admin.products.deals.assign');
        Route::delete('{product}/deals/{deal}/remove', [ProductController::class, 'removeDeal'])->name('admin.products.deals.remove');

        Route::resource('categories', CategoryController::class)->names('admin.categories');
        Route::resource('brands', BrandController::class)->names('admin.brands');
        
        Route::resource('attributes', AttributeController::class)->names('admin.attributes');
        Route::get('products/{product}/attributes', [AttributeController::class, 'showAssignForm'])
            ->name('products.attributes.assign');
        Route::post('products/{product}/attributes', [AttributeController::class, 'assignToProduct'])
            ->name('products.attributes.store');
        Route::delete('products/{product}/attributes/{attribute}', [AttributeController::class, 'removeFromProduct'])
            ->name('products.attributes.remove');

        Route::resource('orders', OrderController::class)->names('admin.orders');
        Route::resource('reviews', ReviewController::class)->names('admin.reviews');
        Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');

        Route::resource('deals', DealController::class)->names('admin.deals');
        Route::patch('deals/{deal}/toggle-status', [DealController::class, 'toggleStatus'])->name('admin.deals.toggle-status');
        Route::patch('deals/{deal}/toggle-featured', [DealController::class, 'toggleDealFeatured'])->name('admin.deals.toggle-featured');
        Route::get('deals/{deal}/products', [DealController::class, 'productsShow'])->name('admin.deals.products.show');
        Route::post('deals/{deal}/products/assign', [DealController::class, 'assignProducts'])->name('admin.deals.products.assign');
        Route::delete('deals/{deal}/products/{product}/remove', [DealController::class, 'removeProduct'])->name('admin.deals.products.remove');
        Route::patch('deals/{deal}/products/{product}/toggle-featured', [DealController::class, 'toggleFeatured'])->name('admin.deals.products.toggle-featured');

        Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('admin.settings.update');

        Route::resource('carousels', CarouselController::class)->names('admin.carousels');
        Route::post('carousels/reorder', [CarouselController::class, 'reorder'])->name('admin.carousels.reorder');

        // Subscribers
        Route::resource('subscribers', SubscriberController::class)->names('admin.subscribers');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

});


// Only for Super Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::prefix('admin')->group(function () {

        // Roles
        Route::get('/role', [RoleController::class, 'role'])->name('admin.role');
        Route::get('/role/create', [RoleController::class, 'roleCreatePage'])->name('admin.role.createPage');
        Route::post('/role/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::get('/role/edit/{id}', [RoleController::class, 'roleEditPage'])->name('admin.role.edit');
        Route::put('/role/update/{id}', [RoleController::class, 'roleUpdate'])->name('admin.role.update');
        Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('admin.role.permissions');
        Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('admin.role.permissions.revoke');


        // Permissions
        Route::get('/permission', [PermissionController::class, 'permission'])->name('admin.permission');
        Route::get('/permission/create', [PermissionController::class, 'permissionCreatePage'])->name('admin.permission.createPage');
        Route::post('/permission/create', [PermissionController::class, 'permissionCreate'])->name('admin.permission.create');
        Route::get('/permission/edit/{id}', [PermissionController::class, 'permissionEditPage'])->name('admin.permission.edit');
        Route::put('/permission/update/{id}', [PermissionController::class, 'permissionUpdate'])->name('admin.permission.update');
        Route::post('/permissions/{permission}/roles', [PermissionController::class, 'givePermission'])->name('admin.permissions.role');
        Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('admin.permissions.roles.revoke');


        // Users
        Route::get('/users', [UserController::class, 'user'])->name('admin.user');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('admin.users.roles');
        Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('admin.users.roles.remove');
        Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('admin.users.permissions');
        Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('admin.users.permissions.revoke');
        Route::post('/users/password-regenerate/{user}', [UserController::class, 'passRegenerate'])->name('admin.users.passRegenerate')->middleware('can:user_edit');
        Route::patch('/user/{user}/block', [UserController::class, 'block'])->name('users.block');
        Route::patch('/user/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');

        Route::get('/check-permissions', [PermissionController::class, 'checkPer']);

    });


});

require __DIR__ . '/auth.php';