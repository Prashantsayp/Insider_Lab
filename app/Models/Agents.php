<?php

namespace App\Models;

use App\Observers\AgentsObserver;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Agents
 * @package App\Models
 * @version August 27, 2020, 3:43 pm UTC
 *
 * @property string $name
 * @property string $email
 * @property string $pan_card
 * @property string $aadhar_card
 * @property string|\Carbon\Carbon $mobile_verified_at
 * @property string $mobile
 * @property string $location
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property boolean $disabled
 * @property string $user_type
 */
class Agents extends Model
{
    // use SoftDeletes;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'pan_card',
        'aadhar_card',
        'mobile_verified_at',
        'mobile',
        'location',
        'email_verified_at',
        'password',
        'remember_token',
        'disabled',
        'user_type',
        'gender',
        'dob',
        'employment_type',
        'work_experience',
        'hold_gov_office',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'address',
        'current_profession',
        'employer_name',
        'whatsapp_number',
        'financial_industry'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'pan_card' => 'string',
        'aadhar_card' => 'string',
        'mobile_verified_at' => 'datetime',
        'mobile' => 'string',
        'location' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'disabled' => 'boolean',
        'user_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'disabled' => 'required',
        'user_type' => 'required'
    ];

    protected static function boot()
    {
        parent::boot();
    }

}
