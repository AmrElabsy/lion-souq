<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);


Route::namespace('App\Http\Controllers')->middleware('auth:sanctum')->group(function (){
    Route::post('product/image', [ProductController::class, 'upload_image']);
    Route::delete('product/image', [ProductController::class, 'delete_images']);
    Route::post('rating', [RatingController::class, 'store']);
    Route::post('cart/product', [CartController::class, 'add_product']);
    Route::delete('cart/product', [CartController::class, 'remove_product']);
    Route::get('cart/me', [CartController::class, 'show']);
    Route::get('vendor/me', [VendorController::class, 'me']);
    Route::get('payment/success/{cart}', [OrderController::class, 'success'])->name('payment.success');
    Route::get('payment/cancel', [OrderController::class, 'cancel'])->name('payment.cancel');
//    Route::post('order', [OrderController::class, 'store']);

    Route::resources([
        'category' => 'CategoryController',
        'product' => 'ProductController',
        'comment' => 'CommentController',
        'order' => 'OrderController',
        'user' => 'UserController',
        'vendor' => 'VendorController',
        'payment-info' => 'PaymentInfoController',
    ]);
});
