<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\SellerCheck;
use App\Http\Controllers\dashboardUsers;
use App\Http\Controllers\dashboardSeller;
use App\Http\Controllers\publicController;
use App\Http\Controllers\basketController;
use App\Http\Controllers\wishListController;
use App\Http\Controllers\buyerController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\notifyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Http\Resources\UserCollection;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {  return view('home'); });
Route::get('/', [publicController::class, 'home']);


Route::get('/wedings', [publicController::class, 'get_all_wedings']);
Route::get('/soaris', [publicController::class, 'get_all_soaris']);
Route::get('/kids', [publicController::class, 'get_all_kids']);
Route::get('/search', [publicController::class, 'search']);
Route::get('/item/{item_id}', [publicController::class, 'view_item']);


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/myorders', [buyerController::class, 'requestedItems']);
    Route::get('/dashboard/receivied-orders', [buyerController::class, 'receiviededOders']);
    Route::get('/basket', [basketController::class, 'get_all_in_basket']);
    Route::post('/basket/add', [basketController::class, 'addItemToBasket']);
    Route::post('/basket/buy', [basketController::class, 'buy_all']);
    Route::post('/basket/update', [basketController::class, 'update']);
    
    Route::post('/wishlist/add', [wishListController::class, 'addItemToWishList']);
    Route::get('/wishlist', [wishListController::class, 'get_all_in_wishlist']);
    Route::post('/basket/clear', [basketController::class, 'clearBasket']);
    Route::post('/wishlist/clear', [wishListController::class, 'clearWishlist']);
    Route::post('/dashboard/notify/deactive', [notifyController::class, 'deactive']);
    Route::post('/dashboard/clearnoti', [notifyController::class, 'clearNotification']);
    
});



Route::middleware(['AdminCheck'])->group(function () {
    Route::get('/dashboard/users', [dashboardUsers::class, 'get_users']);
    Route::post('/dashboard/add', [dashboardUsers::class, 'add_new_user']);
    Route::post('/dashboard/changepass', [dashboardUsers::class, 'changePassword']);
    Route::post('/dashboard/users/active', [dashboardUsers::class, 'active_user']);
    Route::post('/dashboard/users/deactive', [dashboardUsers::class, 'deactive_user']);
    Route::get('/dashboard/users/info/{id}', [dashboardUsers::class, 'get_user_info']);
    Route::post('/dashboard/users/delete/', [dashboardUsers::class, 'delete_user']);
    Route::post('/dashboard/users/subscribe', [dashboardUsers::class, 'subscribe']);
    Route::post('/dashboard/users/search', [dashboardUsers::class, 'search']);
    
    Route::post('/dashboard/orders/delete', [ordersController::class, 'delete_order']);
    // Route::get('/dashboard/orders-items', [ordersController::class, 'get_orders_items']);
    Route::get('/dashboard/manage-orders', [ordersController::class, 'get_orders']);
    Route::post('/dashboard/mange-request/update-status', [ordersController::class, 'update_status']);
    Route::post('/dashboard/orders/info', [ordersController::class, 'getOrdersItems']);
});


Route::middleware(['SellerCheck'])->group(function () {
    Route::get('/dashboard/seller/dersses', [dashboardSeller::class, 'get_dresses']);
    Route::get('/dashboard/seller/add-dersses', [dashboardSeller::class, 'add_dresses']);
    Route::get('/dashboard/seller/active_item/{item_id}', [dashboardSeller::class, 'activeate_item']);
    Route::get('/dashboard/seller/dactive_item/{item_id}', [dashboardSeller::class, 'dactiveate_item']);
    Route::get('/dashboard/seller/delete_item/{item_id}', [dashboardSeller::class, 'delete_item']);
    Route::get('/dashboard/seller/view_item/{item_id}', [dashboardSeller::class, 'view_item']);
    Route::get('/dashboard/seller/activeated_items', [dashboardSeller::class, 'get_active_items']);
    Route::get('/dashboard/seller/dactiveated_items', [dashboardSeller::class, 'get_dactive_items']);
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard_pages.reports');
})->name('dashboard');

