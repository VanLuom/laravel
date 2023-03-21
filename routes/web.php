<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class,'index',CategoryController::class,'inc.banner']);
    

Route::prefix('admin')->group(function(){
    Route::get('post/{post}/comments/{comment}', function ($postId,$commentId) {
        return "postId: $postId - commentId: $commentId";
    });
    Route::get('user/{name?}', function ($name ='john') {
       return $name;
    });

});

Route::get('/home', function () {
    return 'hello world';
})->name('home');
Route::get('/shop', function () {
    return 'page shop';
})->middleware('auth');
Route::post('/post', function () {
    echo 'method post';
});
Route::put('/put', function () {
    echo 'method put';
});

Route::resource('users',UserController::class);
Route::resource('categories',CategoryController::class);
Route::resource('products',ProductController::class);
Route::resource('orders',OrderController::class);
Route::resource('orderitems',OrderItemController::class);
Route::resource('cart',CartController::class);


Route::get('/child',function(){
    return view('layout');
});

Route::group(['prefix' => 'admin'], function(){
    Route::resource('users',App\Http\Controllers\Admin\UserController::class,['names' => 'admin.users']);

    //
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class,['names' =>'admin.products']);

    //
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class,['names' =>'admin.categories']);
   
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\ProductController::class, 'index'])->name('home');
Route::middleware(['auth.check'])->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('cart', [CartController::class, 'showcart'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');



    



});