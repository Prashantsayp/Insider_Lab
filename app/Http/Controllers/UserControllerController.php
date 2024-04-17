<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserControllerRequest;
use App\Http\Requests\UpdateUserControllerRequest;
use App\Repositories\UserControllerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class UserControllerController extends AppBaseController
{
    /** @var  UserControllerRepository */
    private $userControllerRepository;

    public function __construct(UserControllerRepository $userControllerRepo)
    {
        $this->userControllerRepository = $userControllerRepo;
    }

    /**
     * Display a listing of the UserController.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userControllers = $this->userControllerRepository->all();

        return view('user_controllers.index')
            ->with('userControllers', $userControllers);
    }

    /**
     * Show the form for creating a new UserController.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_controllers.create');
    }

    /**
     * Store a newly created UserController in storage.
     *
     * @param CreateUserControllerRequest $request
     *
     * @return Response
     */
    public function store(CreateUserControllerRequest $request)
    {
        $input = $request->all();

        $userController = $this->userControllerRepository->create($input);

        Flash::success('User Controller saved successfully.');

        return redirect(route('userControllers.index'));
    }

    /**
     * Display the specified UserController.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userController = $this->userControllerRepository->find($id);

        if (empty($userController)) {
            Flash::error('User Controller not found');

            return redirect(route('userControllers.index'));
        }

        return view('user_controllers.show')->with('userController', $userController);
    }

    /**
     * Show the form for editing the specified UserController.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userController = $this->userControllerRepository->find($id);

        if (empty($userController)) {
            Flash::error('User Controller not found');

            return redirect(route('userControllers.index'));
        }

        return view('user_controllers.edit')->with('userController', $userController);
    }

    /**
     * Update the specified UserController in storage.
     *
     * @param int $id
     * @param UpdateUserControllerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserControllerRequest $request)
    {
        $userController = $this->userControllerRepository->find($id);

        if (empty($userController)) {
            Flash::error('User Controller not found');

            return redirect(route('userControllers.index'));
        }

        $userController = $this->userControllerRepository->update($request->all(), $id);

        Flash::success('User Controller updated successfully.');

        return redirect(route('userControllers.index'));
    }

    /**
     * Remove the specified UserController from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userController = $this->userControllerRepository->find($id);

        if (empty($userController)) {
            Flash::error('User Controller not found');

            return redirect(route('userControllers.index'));
        }

        $this->userControllerRepository->delete($id);

        Flash::success('User Controller deleted successfully.');

        return redirect(route('userControllers.index'));
    }
}
