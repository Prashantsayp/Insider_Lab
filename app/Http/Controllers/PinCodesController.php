<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePinCodesRequest;
use App\Http\Requests\UpdatePinCodesRequest;
use App\Repositories\PinCodesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PinCodesController extends AppBaseController
{
    /** @var  PinCodesRepository */
    private $pinCodesRepository;

    public function __construct(PinCodesRepository $pinCodesRepo)
    {
        $this->pinCodesRepository = $pinCodesRepo;
    }

    /**
     * Display a listing of the PinCodes.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $pinCodes = $this->pinCodesRepository->all();

        return view('pin_codes.index')
            ->with('pinCodes', $pinCodes);
    }

    /**
     * Show the form for creating a new PinCodes.
     *
     * @return Response
     */
    public function create()
    {
        return view('pin_codes.create');
    }

    /**
     * Store a newly created PinCodes in storage.
     *
     * @param CreatePinCodesRequest $request
     *
     * @return Response
     */
    public function store(CreatePinCodesRequest $request)
    {
        $input = $request->all();

        $pinCodes = $this->pinCodesRepository->create($input);

        Flash::success('Pin Codes saved successfully.');

        return redirect(route('pinCodes.index'));
    }

    /**
     * Display the specified PinCodes.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pinCodes = $this->pinCodesRepository->find($id);

        if (empty($pinCodes)) {
            Flash::error('Pin Codes not found');

            return redirect(route('pinCodes.index'));
        }

        return view('pin_codes.show')->with('pinCodes', $pinCodes);
    }

    /**
     * Show the form for editing the specified PinCodes.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pinCodes = $this->pinCodesRepository->find($id);

        if (empty($pinCodes)) {
            Flash::error('Pin Codes not found');

            return redirect(route('pinCodes.index'));
        }

        return view('pin_codes.edit')->with('pinCodes', $pinCodes);
    }

    /**
     * Update the specified PinCodes in storage.
     *
     * @param int $id
     * @param UpdatePinCodesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePinCodesRequest $request)
    {
        $pinCodes = $this->pinCodesRepository->find($id);

        if (empty($pinCodes)) {
            Flash::error('Pin Codes not found');

            return redirect(route('pinCodes.index'));
        }

        $pinCodes = $this->pinCodesRepository->update($request->all(), $id);

        Flash::success('Pin Codes updated successfully.');

        return redirect(route('pinCodes.index'));
    }

    /**
     * Remove the specified PinCodes from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pinCodes = $this->pinCodesRepository->find($id);

        if (empty($pinCodes)) {
            Flash::error('Pin Codes not found');

            return redirect(route('pinCodes.index'));
        }

        $this->pinCodesRepository->delete($id);

        Flash::success('Pin Codes deleted successfully.');

        return redirect(route('pinCodes.index'));
    }
}
