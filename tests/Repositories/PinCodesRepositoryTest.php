<?php namespace Tests\Repositories;

use App\Models\PinCodes;
use App\Repositories\PinCodesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PinCodesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PinCodesRepository
     */
    protected $pinCodesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->pinCodesRepo = \App::make(PinCodesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->make()->toArray();

        $createdPinCodes = $this->pinCodesRepo->create($pinCodes);

        $createdPinCodes = $createdPinCodes->toArray();
        $this->assertArrayHasKey('id', $createdPinCodes);
        $this->assertNotNull($createdPinCodes['id'], 'Created PinCodes must have id specified');
        $this->assertNotNull(PinCodes::find($createdPinCodes['id']), 'PinCodes with given id must be in DB');
        $this->assertModelData($pinCodes, $createdPinCodes);
    }

    /**
     * @test read
     */
    public function test_read_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->create();

        $dbPinCodes = $this->pinCodesRepo->find($pinCodes->id);

        $dbPinCodes = $dbPinCodes->toArray();
        $this->assertModelData($pinCodes->toArray(), $dbPinCodes);
    }

    /**
     * @test update
     */
    public function test_update_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->create();
        $fakePinCodes = factory(PinCodes::class)->make()->toArray();

        $updatedPinCodes = $this->pinCodesRepo->update($fakePinCodes, $pinCodes->id);

        $this->assertModelData($fakePinCodes, $updatedPinCodes->toArray());
        $dbPinCodes = $this->pinCodesRepo->find($pinCodes->id);
        $this->assertModelData($fakePinCodes, $dbPinCodes->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->create();

        $resp = $this->pinCodesRepo->delete($pinCodes->id);

        $this->assertTrue($resp);
        $this->assertNull(PinCodes::find($pinCodes->id), 'PinCodes should not exist in DB');
    }
}
