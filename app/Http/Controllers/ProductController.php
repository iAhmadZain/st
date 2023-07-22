<?php

namespace App\Http\Controllers;

use App\Services\ProductCache;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productCache;

    public function __construct(ProductCache $productCache)
    {
        $this->productCache = $productCache;
    }

    public function show($id)
    {
        $product = $this->productCache->get($id);

        return view('product.show', ['product' => $product]);
    }
}
