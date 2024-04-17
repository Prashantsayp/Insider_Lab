<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentsRequest;
use App\Http\Requests\UpdateDocumentsRequest;
use App\Repositories\DocumentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class DocumentsController extends AppBaseController
{
    /** @var  DocumentsRepository */
    private $documentsRepository;

    public function __construct(DocumentsRepository $documentsRepo)
    {
        $this->documentsRepository = $documentsRepo;
    }

    /**
     * Display a listing of the Documents.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $documents = $this->documentsRepository->all();

        return view('documents.index')
            ->with('documents', $documents);
    }

    /**
     * Show the form for creating a new Documents.
     *
     * @return Response
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created Documents in storage.
     *
     * @param CreateDocumentsRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentsRequest $request)
    {
        $input = $request->all();

        $documents = $this->documentsRepository->create($input);

        Flash::success('Documents saved successfully.');

        return redirect(route('documents.index'));
    }

    /**
     * Display the specified Documents.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documents = $this->documentsRepository->find($id);

        if (empty($documents)) {
            Flash::error('Documents not found');

            return redirect(route('documents.index'));
        }

        return view('documents.show')->with('documents', $documents);
    }

    /**
     * Show the form for editing the specified Documents.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $documents = $this->documentsRepository->find($id);

        if (empty($documents)) {
            Flash::error('Documents not found');

            return redirect(route('documents.index'));
        }

        return view('documents.edit')->with('documents', $documents);
    }

    /**
     * Update the specified Documents in storage.
     *
     * @param int $id
     * @param UpdateDocumentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentsRequest $request)
    {
        $documents = $this->documentsRepository->find($id);

        if (empty($documents)) {
            Flash::error('Documents not found');

            return redirect(route('documents.index'));
        }

        $documents = $this->documentsRepository->update($request->all(), $id);

        Flash::success('Documents updated successfully.');

        return redirect(route('documents.index'));
    }

    /**
     * Remove the specified Documents from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $documents = $this->documentsRepository->find($id);

        if (empty($documents)) {
            Flash::error('Documents not found');

            return redirect(route('documents.index'));
        }

        $this->documentsRepository->delete($id);

        Flash::success('Documents deleted successfully.');

        return redirect(route('documents.index'));
    }
}
