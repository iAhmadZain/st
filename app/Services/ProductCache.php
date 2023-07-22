<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Product;

class ProductCache
{
    public function get($id)
    {
        return Cache::remember('product_' . $id, 60, function () use ($id) {
            return Product::find($id);
        });
    }
}
