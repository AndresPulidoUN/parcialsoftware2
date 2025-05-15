<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class PruebaParcial extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_category()
    {
        $data = [
            'name' => 'Deportes',
            'description' => 'Prueba 1',
        ];
        $response = $this->postJson('/categories', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => 'Deportes',
            'description' => 'Prueba 1'
        ]);
    }

    public function test_user_can_show_category()
    {
        $category = Category::create([
            'name' => 'Software',
            'description' => 'Prueba Show',
        ]);
        $response = $this->get("/products/{$category->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => 'Software',
                'description' => 'Prueba Show',
            ]
        ]);
    }

    public function test_user_can_update_category()
    {
        $category = Category::create([
            'name' => 'Juegos',
            'description' => 'Test Update',
        ]);
        $data = [
            'name' => 'Games',
            'description' => 'Update Test',
        ];
        $response = $this->put("/categories/{$category->id}", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'name' => 'Games',
            'description' => 'Update Test',
        ]);
    }

    public function test_user_can_delete_category()
    {
        $category = Category::create([
            'name' => 'Deportes',
            'description' => 'Test Delete'
        ]);
        $response = $this->delete("/categories/{$category->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', [
            'name' => 'Deportes',
        ]);
    }
}
