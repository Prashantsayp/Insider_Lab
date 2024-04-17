<?php

namespace App\Repositories;

use App\Models\BankDetails;
use App\Repositories\BaseRepository;

/**
 * Class BankDetailsRepository
 * @package App\Repositories
 * @version September 2, 2020, 4:16 pm UTC
*/

class BankDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bank_details',
        'terms_and_conditions',
        'user_id'
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
        return BankDetails::class;
    }
}
