<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatehomeRequest;
use App\Http\Requests\UpdatehomeRequest;
use App\Repositories\homeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class homeController extends AppBaseController
{
    /** @var  homeRepository */
    private $homeRepository;

    public function __construct(homeRepository $homeRepo)
    {
        $this->homeRepository = $homeRepo;
    }

    /**
     * Display a listing of the home.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $homes = $this->homeRepository->all();

        return view('homes.index')
            ->with('homes', $homes);
    }

    /**
     * Show the form for creating a new home.
     *
     * @return Response
     */
    public function create()
    {
        return view('homes.create');
    }

    /**
     * Store a newly created home in storage.
     *
     * @param CreatehomeRequest $request
     *
     * @return Response
     */
    public function store(CreatehomeRequest $request)
    {
        $input = $request->all();

        $home = $this->homeRepository->create($input);

        Flash::success('Home saved successfully.');

        return redirect(route('homes.index'));
    }

    /**
     * Display the specified home.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $home = $this->homeRepository->find($id);

        if (empty($home)) {
            Flash::error('Home not found');

            return redirect(route('homes.index'));
        }

        return view('homes.show')->with('home', $home);
    }

    /**
     * Show the form for editing the specified home.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $home = $this->homeRepository->find($id);

        if (empty($home)) {
            Flash::error('Home not found');

            return redirect(route('homes.index'));
        }

        return view('homes.edit')->with('home', $home);
    }

    /**
     * Update the specified home in storage.
     *
     * @param int $id
     * @param UpdatehomeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatehomeRequest $request)
    {
        $home = $this->homeRepository->find($id);

        if (empty($home)) {
            Flash::error('Home not found');

            return redirect(route('homes.index'));
        }

        $home = $this->homeRepository->update($request->all(), $id);

        Flash::success('Home updated successfully.');

        return redirect(route('homes.index'));
    }

    /**
     * Remove the specified home from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $home = $this->homeRepository->find($id);

        if (empty($home)) {
            Flash::error('Home not found');

            return redirect(route('homes.index'));
        }

        $this->homeRepository->delete($id);

        Flash::success('Home deleted successfully.');

        return redirect(route('homes.index'));
    }
}
