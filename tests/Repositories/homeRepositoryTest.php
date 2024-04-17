<?php namespace Tests\Repositories;

use App\Models\home;
use App\Repositories\homeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class homeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var homeRepository
     */
    protected $homeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->homeRepo = \App::make(homeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_home()
    {
        $home = factory(home::class)->make()->toArray();

        $createdhome = $this->homeRepo->create($home);

        $createdhome = $createdhome->toArray();
        $this->assertArrayHasKey('id', $createdhome);
        $this->assertNotNull($createdhome['id'], 'Created home must have id specified');
        $this->assertNotNull(home::find($createdhome['id']), 'home with given id must be in DB');
        $this->assertModelData($home, $createdhome);
    }

    /**
     * @test read
     */
    public function test_read_home()
    {
        $home = factory(home::class)->create();

        $dbhome = $this->homeRepo->find($home->id);

        $dbhome = $dbhome->toArray();
        $this->assertModelData($home->toArray(), $dbhome);
    }

    /**
     * @test update
     */
    public function test_update_home()
    {
        $home = factory(home::class)->create();
        $fakehome = factory(home::class)->make()->toArray();

        $updatedhome = $this->homeRepo->update($fakehome, $home->id);

        $this->assertModelData($fakehome, $updatedhome->toArray());
        $dbhome = $this->homeRepo->find($home->id);
        $this->assertModelData($fakehome, $dbhome->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_home()
    {
        $home = factory(home::class)->create();

        $resp = $this->homeRepo->delete($home->id);

        $this->assertTrue($resp);
        $this->assertNull(home::find($home->id), 'home should not exist in DB');
    }
}
