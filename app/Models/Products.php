<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Products
 * @package App\Models
 * @version January 31, 2021, 6:07 pm UTC
 *
 * @property string $name
 * @property integer $bank_id
 * @property string $type
 * @property string $features
 * @property string $ui_listing
 */
class Products extends Model
{
    use SoftDeletes;

    public $table = 'products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'bank_id',
        'type',
        'features',
        'ui_listing'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'bank_id' => 'integer',
        'type' => 'string',
        'features' => 'array',
        'ui_listing' => 'array'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'bank_id' => 'required|integer',
        'type' => 'required|string',
        'features' => 'nullable|string',
        'ui_listing' => 'required|string'
    ];


}
