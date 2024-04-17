<?php namespace Tests\Repositories;

use App\Models\Cases;
use App\Repositories\CasesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CasesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CasesRepository
     */
    protected $casesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->casesRepo = \App::make(CasesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_cases()
    {
        $cases = factory(Cases::class)->make()->toArray();

        $createdCases = $this->casesRepo->create($cases);

        $createdCases = $createdCases->toArray();
        $this->assertArrayHasKey('id', $createdCases);
        $this->assertNotNull($createdCases['id'], 'Created Cases must have id specified');
        $this->assertNotNull(Cases::find($createdCases['id']), 'Cases with given id must be in DB');
        $this->assertModelData($cases, $createdCases);
    }

    /**
     * @test read
     */
    public function test_read_cases()
    {
        $cases = factory(Cases::class)->create();

        $dbCases = $this->casesRepo->find($cases->id);

        $dbCases = $dbCases->toArray();
        $this->assertModelData($cases->toArray(), $dbCases);
    }

    /**
     * @test update
     */
    public function test_update_cases()
    {
        $cases = factory(Cases::class)->create();
        $fakeCases = factory(Cases::class)->make()->toArray();

        $updatedCases = $this->casesRepo->update($fakeCases, $cases->id);

        $this->assertModelData($fakeCases, $updatedCases->toArray());
        $dbCases = $this->casesRepo->find($cases->id);
        $this->assertModelData($fakeCases, $dbCases->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_cases()
    {
        $cases = factory(Cases::class)->create();

        $resp = $this->casesRepo->delete($cases->id);

        $this->assertTrue($resp);
        $this->assertNull(Cases::find($cases->id), 'Cases should not exist in DB');
    }
}
