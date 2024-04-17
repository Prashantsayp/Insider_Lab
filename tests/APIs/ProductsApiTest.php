<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Products;

class ProductsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_products()
    {
        $products = factory(Products::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/products', $products
        );

        $this->assertApiResponse($products);
    }

    /**
     * @test
     */
    public function test_read_products()
    {
        $products = factory(Products::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/products/'.$products->id
        );

        $this->assertApiResponse($products->toArray());
    }

    /**
     * @test
     */
    public function test_update_products()
    {
        $products = factory(Products::class)->create();
        $editedProducts = factory(Products::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/products/'.$products->id,
            $editedProducts
        );

        $this->assertApiResponse($editedProducts);
    }

    /**
     * @test
     */
    public function test_delete_products()
    {
        $products = factory(Products::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/products/'.$products->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/products/'.$products->id
        );

        $this->response->assertStatus(404);
    }
}
