<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        $user = $request->user()->with('profile', 'shop')->where('id', $request->user()->id)->first();

        return response()->json([
            'data' => $user
        ]);
    });

    Route::get('mg/shop', function () {

        $shop = Shop::with('products')->where('public', true)->first();
        return response()->json(['message' => 'Succès', 'data' => $shop, 'status' => 200]);
    });

    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/shops', [ShopController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/shop/{id}', [ShopController::class, 'show'])->middleware('auth:sanctum');
    Route::get('/shop', [ShopController::class, 'myShop'])->middleware('auth:sanctum');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('auth:sanctum')->name('dashboard');

    Route::put('/product/{product}/picture', [ProductController::class, 'updatePicture'])->middleware('auth:sanctum');
    Route::put('/user/picture', [ProfileController::class, 'updatePicture'])->middleware('auth:sanctum');
    Route::put('/user', [ProfileController::class, 'update'])->middleware('auth:sanctum');
    Route::get('/cart', [CartController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/cart', [CartController::class, 'add'])->middleware('auth:sanctum');
    Route::post('/buy', [CartController::class, 'confirm'])->middleware('auth:sanctum');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->middleware('auth:sanctum');

    Route::get('orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
    Route::get('order/{order}', [OrderController::class, 'show'])->middleware('auth:sanctum');
    Route::resource('product', ProductController::class)->middleware('auth:sanctum');
});
Route::fallback(function () {
    return response()->json([
        'message' => 'Page Introuvable'
    ], 404);
});
