<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PinCodes
 * @package App\Models
 * @version January 31, 2021, 7:48 am UTC
 *
 * @property string $pin_code
 * @property boolean $ff_available
 * @property boolean $bank_available
 */
class PinCodes extends Model
{
    use SoftDeletes;

    public $table = 'pincodes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'pin_code',
        'ff_available',
        'bank_available'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pin_code' => 'string',
        'ff_available' => 'boolean',
        'bank_available' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'pin_code' => 'required|string|max:50',
        'ff_available' => 'required|boolean',
        'bank_available' => 'required|boolean',
        'created_at' => 'required',
        'updated_at' => 'required',
        'deleted_at' => 'nullable'
    ];

    
}
