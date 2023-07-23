<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Review;
use App\Models\Cart;
use Illuminate\Http\Request;
use Laravel\Octane\Facades\Octane;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/product/{id}', function (Request $request, $id) {
    $productDetails = Octane::concurrently([
        'product' => function () use ($id) {
            return Product::find($id);
        },
        'reviews' => function () use ($id) {
            return Review::where('product_id', $id)->get();
        },
        'relatedProducts' => function () use ($id) {
            // Fetch related products based on the product category or other criteria
            return Product::where('category_id', $id)->get();
        },
        'cart' => function () use ($request) {
            // Fetch the current user's shopping cart
            return Cart::where('user_id', $request->user()->id)->get();
        },
    ]);

    return view('product', $productDetails);
});
