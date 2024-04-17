<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Agents;

class AgentsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_agents()
    {
        $agents = factory(Agents::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/agents', $agents
        );

        $this->assertApiResponse($agents);
    }

    /**
     * @test
     */
    public function test_read_agents()
    {
        $agents = factory(Agents::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/agents/'.$agents->id
        );

        $this->assertApiResponse($agents->toArray());
    }

    /**
     * @test
     */
    public function test_update_agents()
    {
        $agents = factory(Agents::class)->create();
        $editedAgents = factory(Agents::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/agents/'.$agents->id,
            $editedAgents
        );

        $this->assertApiResponse($editedAgents);
    }

    /**
     * @test
     */
    public function test_delete_agents()
    {
        $agents = factory(Agents::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/agents/'.$agents->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/agents/'.$agents->id
        );

        $this->response->assertStatus(404);
    }
}
