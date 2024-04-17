<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Documents
 * @package App\Models
 * @version February 8, 2021, 7:39 pm UTC
 *
 * @property string $document_url
 * @property string $document_type
 * @property integer $agent_id
 * @property integer $case_id
 */
class Documents extends Model
{
    use SoftDeletes;

    public $table = 'documents';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'document_url',
        'document_type',
        'agent_id',
        'cases_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'document_url' => 'string',
        'document_type' => 'string',
        'agent_id' => 'integer',
        'cases_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'document_url' => 'required|string',
        'document_type' => 'required|string|max:50',
        'agent_id' => 'required|integer',
        'cases_id' => 'required|integer',
        'created_at' => 'required',
        'updated_at' => 'required',
        'deleted_at' => 'nullable'
    ];


}
