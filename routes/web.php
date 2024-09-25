<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModifierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/',[FrontendController::class,'index'])->name('index');


Route::get('/list-menu',[FrontendController::class,'list_menu'])->name('list-menu');
Route::get('/list-menu/table/{name}',[FrontendController::class,'list_menu_table'])->name('list-menu.table');
Route::get('/list-menu/{category}',[FrontendController::class,'list_menu_category'])->name('list-menu-category');
Route::get('/detail-menu/{menu}',[FrontendController::class,'detail_menu'])->name('detail-menu');


Route::get('/contact-us',[FrontendController::class,'contact'])->name('contact-us');


Route::resource('/cart',CartController::class)->except('update');
Route::post('/cart/update',[CartController::class,'cart_update'])->name('cart-update');
Route::post('/cart/update/modifier',[CartController::class,'cart_update_modifier'])->name('cart-update-modifier');
Route::post('/cart/update-all', [CartController::class, 'updateAll'])->name('cart-update-all');


Route::post('/checkout',[OrderController::class,'checkout'])->name('checkout');


Route::get('/callback/return',[PaymentController::class,'return'])->name('callback.return');
Route::get('/midtrans/return',[PaymentController::class,'midtrans_return'])->name('midtrans.return');
Route::post('/callback/notify',[PaymentController::class,'notify'])->name('callback.notify');
Route::get('/callback/cancel',[PaymentController::class,'cancel'])->name('callback.cancel');
// Route::post('/callback/notification', [PaymentController::class, 'notificationHandler'])->name('callback.notification');
// Route::post('/callback/notification', function (){
//     return response('OK', 200);
// })->name('callback.notification');


Route::get('/login', [AuthController::class,'login'])->name('login')->middleware('guest');
Route::post('/loginProcess', [AuthController::class,'loginProcess'])->name('login.process');


Route::get('/register', [AuthController::class,'register'])->name('register');
Route::post('/registerProcess', [AuthController::class,'registerProcess'])->name('register.process');


Route::get('/verify/{phone}/{random_url}',[AuthController::class,'verify'])->name('verify');
Route::post('/verify/process',[AuthController::class,'verifyProcess'])->name('verify.process');
Route::post('/resend/otp',[AuthController::class,'resend'])->name('resend');


// forgot password pakai fontee
Route::get('/forgot-password',[AuthController::class,'forgot_password'])->name('forgot.password');
Route::post('/forgot-password-process',[AuthController::class,'verifyChangePassword'])->name('forgot.password.process');

Route::get('/change-password-token/{phone}',[AuthController::class,'changeToken'])->name('change.token');
Route::post('/change-password-token-confirm',[AuthController::class,'confirmToken'])->name('confirm.token');

Route::get('/password-reset/{random_url}',[AuthController::class,'password_reset'])->name('password.reset');
Route::post('/password-reset/process',[AuthController::class,'password_reset_process'])->name('password.reset.process');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('/dashboard')->group(function () {
    
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');


        // table section
        Route::resource('/table',TableController::class);
        Route::post('/bulk-table',[TableController::class,'bulkActionTable'])->name('bulk.action.table');
        Route::get('/print-table/{id}',[TableController::class,'print_table'])->name('print.table');
        Route::get('/generate-qr-code/{id}',[TableController::class,'generate_qr_code'])->name('generate.qr_code');
        

        // category section
        Route::resource('/category',CategoryController::class);
        Route::post('/bulk-category',[CategoryController::class,'bulkActionCategory'])->name('bulk.action.category');
        

        // modifier section
        Route::resource('/modifier',ModifierController::class);
        Route::post('/bulk-modifier',[ModifierController::class,'bulkActionModifier'])->name('bulk.action.modifier');
        

        // menu section
        Route::resource('/menu',MenuController::class);
        Route::post('/bulk-menu',[MenuController::class,'bulkActionMenu'])->name('bulk.action.menu');


        // order section
        Route::resource('/order',OrderController::class);
        Route::post('/order-update',[OrderController::class,'orderUpdate'])->name('order-update');
        Route::post('/bulk-order',[OrderController::class,'bulkAction'])->name('bulk.action');
        Route::get('/print-order/{id}',[OrderController::class,'print_order'])->name('print.order');
        Route::get('/generate-order/{id}',[PDFController::class,'generateOrder'])->name('order.invoice');
        Route::post('/export-order',[OrderController::class,'export_order'])->name('export-order');
        Route::post('/import-order', [OrderController::class, 'import_order'])->name('import-order');
        Route::post('/reorder',[OrderController::class,'reorder'])->name('reorder');
        

        // kitchen section
        Route::get('/kitchen',[OrderController::class,'kitchen'])->name('kitchen');
        Route::get('/kitchen/{order}',[OrderController::class,'kitchen_edit'])->name('kitchen-edit');
        Route::post('/kitchen/{order}/update',[OrderController::class,'kitchen_update'])->name('kitchen-update');
        Route::get('/print-kitchen/{id}',[OrderController::class,'print_kitchen'])->name('print.kitchen');
        Route::get('/generate-kitchen/{id}',[PDFController::class,'generateKitchen'])->name('kitchen.invoice');
        // Route::get('/generate-kitchen/{id}',[PDFController::class,'generateKitchen'])->name('kitchen.invoice');
        

        // user section
        Route::resource('/user',UserController::class);
        Route::get('/export-user',[UserController::class,'export_user'])->name('export-user');
        Route::post('/bulk-user',[UserController::class,'bulkActionUser'])->name('bulk.action.user');
        

        // role section
        Route::resource('/role',RoleController::class);
        

        // review section
        Route::resource('/review',ReviewController::class);
        Route::post('/bulk-review',[ReviewController::class,'bulkActionReview'])->name('bulk.action.review');
        

        // feedback section
        Route::resource('/feedback',FeedbackController::class);
        Route::post('/bulk-feedback',[FeedbackController::class,'bulkActionFeedback'])->name('bulk.action.feedback');
        

        // profile section
        Route::get('/profile',[DashboardController::class,'profile'])->name('profile');
        Route::put('/profile/{user}/edit',[DashboardController::class,'profile_edit'])->name('profile.edit');
        

        // logout section
        Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    });

});



