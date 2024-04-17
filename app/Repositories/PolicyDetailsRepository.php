<?php

namespace App\Repositories;

use App\Models\PolicyDetails;
use App\Repositories\BaseRepository;

/**
 * Class PolicyDetailsRepository
 * @package App\Repositories
 * @version October 7, 2020, 3:04 pm UTC
*/

class PolicyDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'policy_id',
        'linked_condition_key',
        'condition',
        'condition_value',
        'condition_type',
        'parent_condition_id',
        'parent_condition_value'
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
        return PolicyDetails::class;
    }
}
