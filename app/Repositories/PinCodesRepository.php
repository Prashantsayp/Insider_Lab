<?php

namespace App\Repositories;

use App\Models\PinCodes;
use App\Repositories\BaseRepository;

/**
 * Class PinCodesRepository
 * @package App\Repositories
 * @version January 31, 2021, 7:48 am UTC
*/

class PinCodesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pin_code',
        'ff_available',
        'bank_available'
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
        return PinCodes::class;
    }
}
