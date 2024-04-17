<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MobileVerification
 * @package App\Models
 * @version July 26, 2020, 10:34 am UTC
 *
 * @property string $mobile_number
 * @property string $otp
 * @property boolean $is_verified
 */
class MobileVerification extends Model
{
    use SoftDeletes;

    public $table = 'create_mobile_verification_tables';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'mobile_number',
        'otp',
        'is_verified'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mobile_number' => 'string',
        'otp' => 'string',
        'is_verified' => 'boolean',
        "created_at" => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mobile_number' => 'required',
        'is_verified' => 'required',
        'created_at' => 'required',
    ];


}
