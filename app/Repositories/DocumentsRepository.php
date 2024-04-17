<?php

namespace App\Repositories;

use App\Models\Documents;
use App\Repositories\BaseRepository;

/**
 * Class DocumentsRepository
 * @package App\Repositories
 * @version February 8, 2021, 7:39 pm UTC
*/

class DocumentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'document_url',
        'document_type',
        'agent_id',
        'case_id'
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
        return Documents::class;
    }
}
