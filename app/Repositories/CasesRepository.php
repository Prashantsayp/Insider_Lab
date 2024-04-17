<?php

namespace App\Repositories;

use App\Models\Cases;
use App\Repositories\BaseRepository;

/**
 * Class CasesRepository
 * @package App\Repositories
 * @version September 3, 2020, 3:22 pm UTC
*/

class CasesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'mobile'
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
        return Cases::class;
    }
}
