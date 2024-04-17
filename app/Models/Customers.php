<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customers extends Model
{
    use SoftDeletes;

    public $table = 'customers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'pincode',
        'pan',
        'date_of_birth',
        'email',
        'gender',
        'merital_status',
        'aadhar_number',
        'merital_status',
        'highest_degree_id',
        'permanent_address'
    ];

    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'mobile' => 'required|string|max:50'
        ];

    
}
