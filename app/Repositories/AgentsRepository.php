<?php

namespace App\Repositories;

use App\Models\Agents;
use App\Repositories\BaseRepository;

/**
 * Class AgentsRepository
 * @package App\Repositories
 * @version August 27, 2020, 3:43 pm UTC
*/

class AgentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'pan_card',
        'aadhar_card',
        'mobile_verified_at',
        'mobile',
        'location',
        'email_verified_at',
        'password',
        'remember_token',
        'disabled',
        'user_type'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Agents::class;
    }
}
