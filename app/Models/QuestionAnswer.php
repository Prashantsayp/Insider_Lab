<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuestionAnswer
 * @package App\Models
 * @version July 27, 2020, 1:48 am UTC
 *
 * @property integer $user_id
 * @property string $question_list
 */
class QuestionAnswer extends Model
{
    use SoftDeletes;

    public $table = 'question_answer';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'question_list'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'question_list' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'question_list' => 'required'
    ];

    
}
