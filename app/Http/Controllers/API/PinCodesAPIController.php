<?php

namespace App\Http\Controllers\API;

use Response;
use App\Models\PinCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PinCodesResource;
use App\Repositories\PinCodesRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePinCodesAPIRequest;
use App\Http\Requests\API\UpdatePinCodesAPIRequest;

/**
 * Class PinCodesController
 * @package App\Http\Controllers\API
 */

class PinCodesAPIController extends AppBaseController
{
    /** @var  PinCodesRepository */
    private $pinCodesRepository;

    public function __construct(PinCodesRepository $pinCodesRepo)
    {
        $this->pinCodesRepository = $pinCodesRepo;
    }

    /**
     * Display a listing of the PinCodes.
     * GET|HEAD /pinCodes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pinCodes = $this->pinCodesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PinCodesResource::collection($pinCodes), 'Pin Codes retrieved successfully');
    }

    /**
     * Store a newly created PinCodes in storage.
     * POST /pinCodes
     *
     * @param CreatePinCodesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePinCodesAPIRequest $request)
    {
        $input = $request->all();

        $pinCodes = $this->pinCodesRepository->create($input);

        return $this->sendResponse(new PinCodesResource($pinCodes), 'Pin Codes saved successfully');
    }

    /**
     * Display the specified PinCodes.
     * GET|HEAD /pinCodes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PinCodes $pinCodes */
        Log::info('Pin Code', [$id]);
        $pinCodes = PinCodes::where([["pin_code", "=", $id]])->first();
        Log::info('Pin Code List ', [$pinCodes]);
        if (empty($pinCodes)) {
            return response()->json([
                "error" => 1,
                "message" => "Pin code not found.",
                "show_message" => true,
                "data" => []
            ]);
        }

        return $this->sendResponse(new PinCodesResource($pinCodes), 'Pin Codes retrieved successfully');
    }

    /**
     * Display the specified PinCodes.
     * GET|HEAD /pinCodes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function find($pincode)
    {
        /** @var PinCodes $pinCodes */
        $pinCodes = PinCodes::where([["pin_code", "=", $pincode]])->first();

        if (empty($pinCodes)) {
            return $this->sendError('Pin Codes not found');
        }

        return $this->sendResponse(new PinCodesResource($pinCodes), 'Pin Codes retrieved successfully');
    }

    /**
     * Update the specified PinCodes in storage.
     * PUT/PATCH /pinCodes/{id}
     *
     * @param int $id
     * @param UpdatePinCodesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePinCodesAPIRequest $request)
    {
        $input = $request->all();

        /** @var PinCodes $pinCodes */
        $pinCodes = $this->pinCodesRepository->find($id);

        if (empty($pinCodes)) {
            return $this->sendError('Pin Codes not found');
        }

        $pinCodes = $this->pinCodesRepository->update($input, $id);

        return $this->sendResponse(new PinCodesResource($pinCodes), 'PinCodes updated successfully');
    }

    /**
     * Remove the specified PinCodes from storage.
     * DELETE /pinCodes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PinCodes $pinCodes */
        $pinCodes = $this->pinCodesRepository->find($id);

        if (empty($pinCodes)) {
            return $this->sendError('Pin Codes not found');
        }

        $pinCodes->delete();

        return $this->sendSuccess('Pin Codes deleted successfully');
    }
}
