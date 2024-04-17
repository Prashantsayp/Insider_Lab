<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BankDetails
 * @package App\Models
 * @version September 2, 2020, 4:16 pm UTC
 *
 * @property string $bank_details
 * @property string $terms_and_conditions
 * @property integer $user_id
 */
class BankDetails extends Model
{
    use SoftDeletes;

    public $table = 'bank_details';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'bank_details',
        'terms_and_conditions',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'bank_details' => 'array',
        'terms_and_conditions' => 'array',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'bank_details' => 'required',
        'terms_and_conditions' => 'required',
        'user_id' => 'required'
    ];


}
