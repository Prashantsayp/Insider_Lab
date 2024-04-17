<?php

namespace App\Repositories;

use App\Models\ProfessionalPolicyDetails;
use App\Repositories\BaseRepository;

/**
 * Class ProfessionalPolicyDetailsRepository
 * @package App\Repositories
 * @version January 24, 2021, 4:41 pm UTC
*/

class ProfessionalPolicyDetailsRepository extends BaseRepository
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
        'parent_condition_value',
        'calculation_field',
        'final_value'
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
        return ProfessionalPolicyDetails::class;
    }
}
