<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_returns_a_view_with_product_details()
    {
        // Arrange
        $product = Product::factory()->create();
        $reviews = Review::factory()->count(3)->create(['product_id' => $product->id]);
        $relatedProducts = Product::factory()->count(3)->create(['category_id' => $product->category_id]);
        $cart = Cart::factory()->create(['user_id' => $product->user_id]);

        // Act
        $response = $this->get("/product/{$product->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('product');
        $response->assertViewHasAll([
            'product' => $product->fresh(),
            'reviews' => $reviews,
            'relatedProducts' => $relatedProducts,
            'cart' => $cart,
        ]);
    }
}
