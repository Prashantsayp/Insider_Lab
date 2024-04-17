<?php

namespace App\Http\Controllers\API;

use Response;
use App\Models\Agents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\AgentsResource;
use App\Repositories\AgentsRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateAgentsAPIRequest;
use App\Http\Requests\API\UpdateAgentsAPIRequest;

/**
 * Class AgentsController
 * @package App\Http\Controllers\API
 */

class AgentsAPIController extends AppBaseController
{
    /** @var  AgentsRepository */
    private $agentsRepository;

    public function __construct(AgentsRepository $agentsRepo)
    {
        $this->agentsRepository = $agentsRepo;
    }

    /**
     * Display a listing of the Agents.
     * GET|HEAD /agents
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $agents = $this->agentsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AgentsResource::collection($agents), 'Agents retrieved successfully');
    }

    /**
     * Store a newly created Agents in storage.
     * POST /agents
     *
     * @param CreateAgentsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAgentsAPIRequest $request)
    {
        $input = $request->all();

        $agents = $this->agentsRepository->create($input);

        return $this->sendResponse(new AgentsResource($agents), 'Agents saved successfully');
    }

    /**
     * Display the specified Agents.
     * GET|HEAD /agents/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Agents $agents */
        $agents = $this->agentsRepository->find($id);

        if (empty($agents)) {
            return $this->sendError('Agents not found');
        }

        return $this->sendResponse(new AgentsResource($agents), 'Agents retrieved successfully');
    }

    /**
     * Update the specified Agents in storage.
     * PUT/PATCH /agents/{id}
     *
     * @param int $id
     * @param UpdateAgentsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgentsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Agents $agents */
        $agents = $this->agentsRepository->find($id);
        Log::info("Agent", [$agents, $input]);
        if (empty($agents)) {
            return $this->sendError('Agents not found');
        }

        $agents = $this->agentsRepository->update($input, $id);
        Log::info("Agent Updated", [$agents]);
        return $this->sendResponse(new AgentsResource($agents), 'Agents updated successfully');
    }

    /**
     * Remove the specified Agents from storage.
     * DELETE /agents/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Agents $agents */
        $agents = $this->agentsRepository->find($id);

        if (empty($agents)) {
            return $this->sendError('Agents not found');
        }

        $agents->delete();

        return $this->sendSuccess('Agents deleted successfully');
    }
}
