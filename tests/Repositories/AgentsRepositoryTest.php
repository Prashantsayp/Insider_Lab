<?php namespace Tests\Repositories;

use App\Models\Agents;
use App\Repositories\AgentsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AgentsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AgentsRepository
     */
    protected $agentsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->agentsRepo = \App::make(AgentsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_agents()
    {
        $agents = factory(Agents::class)->make()->toArray();

        $createdAgents = $this->agentsRepo->create($agents);

        $createdAgents = $createdAgents->toArray();
        $this->assertArrayHasKey('id', $createdAgents);
        $this->assertNotNull($createdAgents['id'], 'Created Agents must have id specified');
        $this->assertNotNull(Agents::find($createdAgents['id']), 'Agents with given id must be in DB');
        $this->assertModelData($agents, $createdAgents);
    }

    /**
     * @test read
     */
    public function test_read_agents()
    {
        $agents = factory(Agents::class)->create();

        $dbAgents = $this->agentsRepo->find($agents->id);

        $dbAgents = $dbAgents->toArray();
        $this->assertModelData($agents->toArray(), $dbAgents);
    }

    /**
     * @test update
     */
    public function test_update_agents()
    {
        $agents = factory(Agents::class)->create();
        $fakeAgents = factory(Agents::class)->make()->toArray();

        $updatedAgents = $this->agentsRepo->update($fakeAgents, $agents->id);

        $this->assertModelData($fakeAgents, $updatedAgents->toArray());
        $dbAgents = $this->agentsRepo->find($agents->id);
        $this->assertModelData($fakeAgents, $dbAgents->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_agents()
    {
        $agents = factory(Agents::class)->create();

        $resp = $this->agentsRepo->delete($agents->id);

        $this->assertTrue($resp);
        $this->assertNull(Agents::find($agents->id), 'Agents should not exist in DB');
    }
}
