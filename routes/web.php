<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\SellerCheck;
use App\Http\Middleware\MarketerCheck;
use App\Http\Controllers\dashboardUsers;
use App\Http\Controllers\dashboardSeller;
use App\Http\Controllers\publicController;
use App\Http\Controllers\basketController;
use App\Http\Controllers\wishListController;
use App\Http\Controllers\buyerController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\notifyController;
use App\Http\Controllers\marketersController;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Http\Resources\UserCollection;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// use App\Http\Controllers\HomeController;
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


Route::get('/', [publicController::class, 'home']);
Route::get('/affiliate-program', [publicController::class, 'affiliaterRegister']);
Route::get('/wedings', [publicController::class, 'get_all_wedings']);
Route::get('/soaris', [publicController::class, 'get_all_soaris']);
Route::get('/kids', [publicController::class, 'get_all_kids']);
Route::get('/search', [publicController::class, 'search']);
Route::get('/item/{item_id}', [publicController::class, 'view_item']);


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard/profile', [dashboardUsers::class, 'profile']);
    Route::post('/profile/image', [dashboardUsers::class, 'profile_image']);
    Route::post('/profile/changepass', [dashboardUsers::class, 'profile_changepass']);
    Route::get('/dashboard/myorders', [buyerController::class, 'requestedItems']);
    Route::get('/dashboard/receivied-orders', [buyerController::class, 'receiviededOders']);
    Route::get('/basket', [basketController::class, 'get_all_in_basket']);
    Route::post('/basket/add', [basketController::class, 'addItemToBasket']);
    Route::post('/basket/buy', [basketController::class, 'buy_all']);
    Route::post('/basket/update', [basketController::class, 'update']);
    Route::post('/basket/clear', [basketController::class, 'clearBasket']);
    Route::get('/basket/delete/{item_id}', [basketController::class, 'deleteBasketItem']);
    Route::post('/basket/itemInfo', [basketController::class, 'itemInfo']);
    
    Route::post('/wishlist/add', [wishListController::class, 'addItemToWishList']);
    Route::get('/wishlist', [wishListController::class, 'get_all_in_wishlist']);
    Route::post('/wishlist/clear', [wishListController::class, 'clearWishlist']);
    Route::post('/dashboard/notify/deactive', [notifyController::class, 'deactive']);
    Route::post('/dashboard/clearnoti', [notifyController::class, 'clearNotification']);
    Route::post('/dashboard/orders/info', [ordersController::class, 'getOrdersItems']);
    
});



Route::middleware(['AdminCheck','verified'])->group(function () {
    Route::get('/dashboard/users', [dashboardUsers::class, 'get_users']);
    Route::post('/dashboard/add', [dashboardUsers::class, 'add_new_user']);
    Route::post('/dashboard/changepass', [dashboardUsers::class, 'changePassword']);
    Route::post('/dashboard/users/active', [dashboardUsers::class, 'active_user']);
    Route::post('/dashboard/users/deactive', [dashboardUsers::class, 'deactive_user']);
    Route::get('/dashboard/users/info/{id}', [dashboardUsers::class, 'get_user_info']);
    Route::post('/dashboard/users/delete/', [dashboardUsers::class, 'delete_user']);
    Route::post('/dashboard/users/subscribe', [dashboardUsers::class, 'subscribe']);
    Route::post('/dashboard/users/search', [dashboardUsers::class, 'search']);
    Route::get('/dashboard/users/planReq', [dashboardUsers::class, 'planReq']);
    Route::get('/dashboard/users/paymentReq', [dashboardUsers::class, 'paymentReq']);
    Route::post('/dashboard/users/makepaid', [dashboardUsers::class, 'makePaid']);
    
    Route::post('/dashboard/orders/delete', [ordersController::class, 'delete_order']);
    Route::get('/dashboard/manage-orders', [ordersController::class, 'get_orders']);
    Route::post('/dashboard/mange-request/update-status', [ordersController::class, 'update_status']);
});


Route::middleware(['SellerCheck','verified'])->group(function () {
    Route::get('/dashboard/seller/dresses', [dashboardSeller::class, 'get_dresses']);
    Route::get('/dashboard/seller/add-dersses', [dashboardSeller::class, 'add_dresses']);
    Route::post('/dashboard/seller/add-dersses', [dashboardSeller::class, 'save_dresses']);
    Route::get('/dashboard/seller/active_item/{item_id}', [dashboardSeller::class, 'activeate_item']);
    Route::get('/dashboard/seller/dactive_item/{item_id}', [dashboardSeller::class, 'dactiveate_item']);
    Route::get('/dashboard/seller/delete_item/{item_id}', [dashboardSeller::class, 'delete_item']);
    Route::get('/dashboard/seller/view_item/{item_id}', [dashboardSeller::class, 'view_item']);
    Route::get('/dashboard/seller/activeated_items', [dashboardSeller::class, 'get_active_items']);
    Route::get('/dashboard/seller/dactiveated_items', [dashboardSeller::class, 'get_dactive_items']);
    Route::get('/dashboard/seller/almost_done_items', [dashboardSeller::class, 'almost_done_items']);
    Route::get('/dashboard/seller/done_items', [dashboardSeller::class, 'done_items']);
    Route::post('/subscribe/plan', [dashboardSeller::class, 'plan']);
    Route::get('/subscription', [publicController::class, 'subsciptions']);
    Route::post('/api/seller/item-quan', [dashboardSeller::class, 'api_getItemQuan']);
    Route::post('/api/quantity/increase', [dashboardSeller::class, 'api_increaseItemQuan']);
    Route::post('/api/quantity/decrease', [dashboardSeller::class, 'api_decreaseItemQuan']);

});

Route::middleware(['MarketerCheck','verified'])->group(function () {
    Route::get('/payments', [marketersController::class, 'payments']) ;
    Route::post('/get-paid', [marketersController::class, 'get_paid']) ;
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard_pages.reports');
})->name('dashboard');


Route::get('/email/verify', function () {
    // check if user already registered
    if (Auth::check() && Auth::user()->account_active != null && Auth::user()->account_active == 1) {
        # code...
        notify("الحساب مفعل مسبقا","Toast","warning");
    return redirect('/');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    
    // check if user already registered
    if (Auth::user()->account_active != null && Auth::user()->account_active == 1) {
        # code...
        notify("الحساب مفعل مسبقا","Toast","warning");
    return redirect('/');
    }

    // verify email
    $request->fulfill();
    // active acount
    $status = DB::update('update users set account_active = true where id = ?', [Auth::user()->id]);

    if ($status) {
        notify("تم تفعيل حسابك بنجاح","Toast","success");
        return redirect('/dashboard');
    }else {

        if (Auth::user()->account_active != null && Auth::user()->account_active == 1) {
            notify("الحساب مفعل مسبقا","Toast","warning");
        return redirect('/');
        }
        notify("لم يتم تفعيل حسابك","Toast","danger");
        return redirect('/');
    }

})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


