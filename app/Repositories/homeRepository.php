<?php

namespace App\Repositories;

use App\Models\home;
use App\Repositories\BaseRepository;

/**
 * Class homeRepository
 * @package App\Repositories
 * @version September 14, 2020, 2:42 pm UTC
*/

class homeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
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
        return home::class;
    }
}
