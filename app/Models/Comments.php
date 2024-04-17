<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class PolicyDetails
 * @package App\Models
 * @version October 7, 2020, 3:04 pm UTC
 *
 * @property integer $policy_id
 * @property string $linked_condition_key
 * @property string $condition
 * @property integer $condition_value
 * @property string $condition_type
 * @property integer $parent_condition_id
 * @property string $parent_condition_value
 */
class Comments extends Model
{
    //use SoftDeletes;

    public $table = 'comments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_comments',
        'case_comments',
        'case_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'id' => 'integer',
        // 'policy_id' => 'integer',
        // 'linked_condition_key' => 'string',
        // 'condition' => 'string',
        // 'condition_value' => 'string',
        // 'condition_type' => 'string',
        // 'parent_condition_id' => 'integer',
        // 'parent_condition_value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'policy_id' => 'required',
        // 'linked_condition_key' => 'required',
        // 'condition' => 'required',
        // 'condition_value' => 'required',
        // 'condition_type' => 'required'
    ];
   
}
