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
class AgentTransaction extends Model
{
    // use SoftDeletes;

    public $table = 'agent_transaction';

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
        'agent_id',
        'from',
        'to',
        'total_amount',
        'reference_no',
        'receipt',
        
    ];

   
   
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'from' => 'required',
        'to' => 'required',
        'total_amount' => 'required',
        'reference_no' => 'required',
        'receipt' => 'required'
    ];

    protected static function boot()
    {
        parent::boot();
    }

}
