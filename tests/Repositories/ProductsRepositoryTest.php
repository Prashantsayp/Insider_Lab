<?php namespace Tests\Repositories;

use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProductsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductsRepository
     */
    protected $productsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->productsRepo = \App::make(ProductsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_products()
    {
        $products = factory(Products::class)->make()->toArray();

        $createdProducts = $this->productsRepo->create($products);

        $createdProducts = $createdProducts->toArray();
        $this->assertArrayHasKey('id', $createdProducts);
        $this->assertNotNull($createdProducts['id'], 'Created Products must have id specified');
        $this->assertNotNull(Products::find($createdProducts['id']), 'Products with given id must be in DB');
        $this->assertModelData($products, $createdProducts);
    }

    /**
     * @test read
     */
    public function test_read_products()
    {
        $products = factory(Products::class)->create();

        $dbProducts = $this->productsRepo->find($products->id);

        $dbProducts = $dbProducts->toArray();
        $this->assertModelData($products->toArray(), $dbProducts);
    }

    /**
     * @test update
     */
    public function test_update_products()
    {
        $products = factory(Products::class)->create();
        $fakeProducts = factory(Products::class)->make()->toArray();

        $updatedProducts = $this->productsRepo->update($fakeProducts, $products->id);

        $this->assertModelData($fakeProducts, $updatedProducts->toArray());
        $dbProducts = $this->productsRepo->find($products->id);
        $this->assertModelData($fakeProducts, $dbProducts->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_products()
    {
        $products = factory(Products::class)->create();

        $resp = $this->productsRepo->delete($products->id);

        $this->assertTrue($resp);
        $this->assertNull(Products::find($products->id), 'Products should not exist in DB');
    }
}
