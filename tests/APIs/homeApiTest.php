<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\home;

class homeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_home()
    {
        $home = factory(home::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/homes', $home
        );

        $this->assertApiResponse($home);
    }

    /**
     * @test
     */
    public function test_read_home()
    {
        $home = factory(home::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/homes/'.$home->id
        );

        $this->assertApiResponse($home->toArray());
    }

    /**
     * @test
     */
    public function test_update_home()
    {
        $home = factory(home::class)->create();
        $editedhome = factory(home::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/homes/'.$home->id,
            $editedhome
        );

        $this->assertApiResponse($editedhome);
    }

    /**
     * @test
     */
    public function test_delete_home()
    {
        $home = factory(home::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/homes/'.$home->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/homes/'.$home->id
        );

        $this->response->assertStatus(404);
    }
}
