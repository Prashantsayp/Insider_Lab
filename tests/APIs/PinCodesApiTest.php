<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PinCodes;

class PinCodesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/pin_codes', $pinCodes
        );

        $this->assertApiResponse($pinCodes);
    }

    /**
     * @test
     */
    public function test_read_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/pin_codes/'.$pinCodes->id
        );

        $this->assertApiResponse($pinCodes->toArray());
    }

    /**
     * @test
     */
    public function test_update_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->create();
        $editedPinCodes = factory(PinCodes::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/pin_codes/'.$pinCodes->id,
            $editedPinCodes
        );

        $this->assertApiResponse($editedPinCodes);
    }

    /**
     * @test
     */
    public function test_delete_pin_codes()
    {
        $pinCodes = factory(PinCodes::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/pin_codes/'.$pinCodes->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/pin_codes/'.$pinCodes->id
        );

        $this->response->assertStatus(404);
    }
}
