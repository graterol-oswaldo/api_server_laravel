<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\{Product, User};

class ProductModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_the_products_list()
    {
        $this->actingAs(User::factory()->create()); 
        
        Product::create([
            "title" => "iPad 4 Mini",
            "price" => 500.01,
            "inventory" => 2 ,
            "photo" => "cafe.jpg"    
        ]);

        $response = $this->get('api/auth/products')
            ->assertStatus(200)
            ->assertSee("iPad 4 Mini")
            ->assertSee(500.01)
            ->assertSee(2)
            ->assertSee("cafe.jpg");
    }
}
