<?php

namespace App\Observers;

use App\Models\Agents;

class AgentsObserver
{
    /**
     * Handle the agents "created" event.
     *
     * @param  \App\Agents  $agents
     * @return void
     */
    public function created(Agents $agents)
    {
        //
    }

    /**
     * Handle the agents "updated" event.
     *
     * @param  \App\Agents  $agents
     * @return void
     */
    public function updated(Agents $agents)
    {
        //
    }

    /**
     * Handle the agents "deleted" event.
     *
     * @param  \App\Agents  $agents
     * @return void
     */
    public function deleted(Agents $agents)
    {
        //
    }

    /**
     * Handle the agents "restored" event.
     *
     * @param  \App\Agents  $agents
     * @return void
     */
    public function restored(Agents $agents)
    {
        //
    }

    /**
     * Handle the agents "force deleted" event.
     *
     * @param  \App\Agents  $agents
     * @return void
     */
    public function forceDeleted(Agents $agents)
    {
        //
    }
}
