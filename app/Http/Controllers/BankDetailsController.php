<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankDetailsRequest;
use App\Http\Requests\UpdateBankDetailsRequest;
use App\Repositories\BankDetailsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BankDetailsController extends AppBaseController
{
    /** @var  BankDetailsRepository */
    private $bankDetailsRepository;

    public function __construct(BankDetailsRepository $bankDetailsRepo)
    {
        $this->bankDetailsRepository = $bankDetailsRepo;
    }

    /**
     * Display a listing of the BankDetails.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $bankDetails = $this->bankDetailsRepository->all();

        return view('bank_details.index')
            ->with('bankDetails', $bankDetails);
    }

    /**
     * Show the form for creating a new BankDetails.
     *
     * @return Response
     */
    public function create()
    {
        return view('bank_details.create');
    }

    /**
     * Store a newly created BankDetails in storage.
     *
     * @param CreateBankDetailsRequest $request
     *
     * @return Response
     */
    public function store(CreateBankDetailsRequest $request)
    {
        $input = $request->all();

        $bankDetails = $this->bankDetailsRepository->create($input);

        Flash::success('Bank Details saved successfully.');

        return redirect(route('bankDetails.index'));
    }

    /**
     * Display the specified BankDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bankDetails = $this->bankDetailsRepository->find($id);

        if (empty($bankDetails)) {
            Flash::error('Bank Details not found');

            return redirect(route('bankDetails.index'));
        }

        return view('bank_details.show')->with('bankDetails', $bankDetails);
    }

    /**
     * Show the form for editing the specified BankDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bankDetails = $this->bankDetailsRepository->find($id);

        if (empty($bankDetails)) {
            Flash::error('Bank Details not found');

            return redirect(route('bankDetails.index'));
        }

        return view('bank_details.edit')->with('bankDetails', $bankDetails);
    }

    /**
     * Update the specified BankDetails in storage.
     *
     * @param int $id
     * @param UpdateBankDetailsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBankDetailsRequest $request)
    {
        $bankDetails = $this->bankDetailsRepository->find($id);

        if (empty($bankDetails)) {
            Flash::error('Bank Details not found');

            return redirect(route('bankDetails.index'));
        }

        $bankDetails = $this->bankDetailsRepository->update($request->all(), $id);

        Flash::success('Bank Details updated successfully.');

        return redirect(route('bankDetails.index'));
    }

    /**
     * Remove the specified BankDetails from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bankDetails = $this->bankDetailsRepository->find($id);

        if (empty($bankDetails)) {
            Flash::error('Bank Details not found');

            return redirect(route('bankDetails.index'));
        }

        $this->bankDetailsRepository->delete($id);

        Flash::success('Bank Details deleted successfully.');

        return redirect(route('bankDetails.index'));
    }
}
