<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;

class PruebaSales extends TestCase
{
   use RefreshDatabase;
    public function test_user_can_create_product()
    {
        $data = [
            'name' => 'Televisor Samsung',
            'price' => 1500000,
            'available' => true,
            'category' => 'electronica',
        ];
        $response = $this->postJson('/products', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => 'Televisor Samsung',
            'price' => 1500000,
            'available' => true,
            'category' => 'electronica',
        ]);
    }

    public function test_user_can_show_product()
    {
        $product = Product:: create([
            'name' => 'Camiseta Nike',
            'price' => 25000,
            'available' => true,
            'category' => 'ropa',
        ]);
        $response = $this->get("/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => 'Camiseta Nike',
                'price' => 25000,
                'available' => 1,
                'category' => 'ropa',
            ]
        ]);
    }

    public function test_user_can_update_product()
    {
        $product = Product:: create([
            'name' => 'Camiseta Adidas',
            'price' => 30000,
            'available' => true,
            'category' => 'ropa',
        ]);
        $data = [
            'name' => 'Camiseta Puma',
            'price' => 35000,
            'available' => false,
            'category' => 'ropa',
        ];
        $response = $this->put("/products/{$product->id}", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Camiseta Puma',
            'price' => 35000,
            'available' => 0,
            'category' => 'ropa',
        ]);
    }
    public function test_user_can_delete_product()
    {
        $product = Product:: create([
            'name' => 'Zapatos Nike',
            'price' => 60000,
            'available' => true,
            'category' => 'ropa',
        ]);
        $response = $this->delete("/products/{$product->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', [
            'name' => 'Zapatos Nike',
        ]);
    }
}
