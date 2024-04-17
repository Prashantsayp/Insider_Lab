<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Cases;

class CasesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_cases()
    {
        $cases = factory(Cases::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/cases', $cases
        );

        $this->assertApiResponse($cases);
    }

    /**
     * @test
     */
    public function test_read_cases()
    {
        $cases = factory(Cases::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/cases/'.$cases->id
        );

        $this->assertApiResponse($cases->toArray());
    }

    /**
     * @test
     */
    public function test_update_cases()
    {
        $cases = factory(Cases::class)->create();
        $editedCases = factory(Cases::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/cases/'.$cases->id,
            $editedCases
        );

        $this->assertApiResponse($editedCases);
    }

    /**
     * @test
     */
    public function test_delete_cases()
    {
        $cases = factory(Cases::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/cases/'.$cases->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/cases/'.$cases->id
        );

        $this->response->assertStatus(404);
    }
}
