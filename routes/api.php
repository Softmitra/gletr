<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Public API routes (authenticated users)
    Route::get('/categories', function () {
        return \App\Models\Category::with('children')->whereNull('parent_id')->get();
    });
    
    Route::get('/products', function () {
        return \App\Models\Product::with(['category', 'seller', 'variants'])->paginate(15);
    });
    
    // Customer API routes
    Route::middleware('customer')->prefix('customer')->group(function () {
        Route::get('/orders', function () {
            return \App\Models\Order::where('user_id', auth()->id())
                ->with(['items.product', 'items.variant'])
                ->paginate(15);
        });
        
        Route::get('/reviews', function () {
            return \App\Models\Review::where('user_id', auth()->id())
                ->with('product')
                ->paginate(15);
        });
    });
    
    // Seller API routes
    Route::middleware('seller')->prefix('seller')->group(function () {
        Route::get('/products', function () {
            $seller = \App\Models\Seller::where('email', auth()->user()->email)->first();
            return \App\Models\Product::where('seller_id', $seller->id)
                ->with(['category', 'variants'])
                ->paginate(15);
        });
        
        Route::get('/orders', function () {
            $seller = \App\Models\Seller::where('email', auth()->user()->email)->first();
            return \App\Models\Order::whereHas('items.product', function($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })->with(['user', 'items.product'])->paginate(15);
        });
    });
    
    // Admin API routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/users', function () {
            return \App\Models\User::with('roles')->paginate(15);
        });
        
        Route::get('/sellers', function () {
            return \App\Models\Seller::paginate(15);
        });
        
        Route::get('/products', function () {
            return \App\Models\Product::with(['seller', 'category'])->paginate(15);
        });
        
        Route::get('/orders', function () {
            return \App\Models\Order::with(['user', 'items.product'])->paginate(15);
        });
    });
});