<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Cases
 * @package App\Models
 * @version September 3, 2020, 3:22 pm UTC
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 */
class CaseFinalBankApproval extends Model
{
    use SoftDeletes;

    public $table = 'case_final_bank_approval';

    public $fillable = [
        'case_id',
        'loan_amount',
        'tenure',
        'processing_fees',
        'interest_rate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'id' => 'integer',
        // 'first_name' => 'string',
        // 'last_name' => 'string',
        // 'mobile' => 'string',
        // "pin_code" => 'string',
        // "pan_card" => 'string',
        // "date_of_birth" => 'timestamp',
        // "company" => 'string',
        // "field_of_work" => 'string',
        // "designation" => 'string',
        // "monthly_salary" => 'string',
        // "monthly_emi" => 'string',
        // "load_type" => 'string',
        // "load_amount" => 'string',
        // "mode_of_salary" => 'string',
        // "salary_bank" => 'string',
        // "load_purpose" => 'string',
        // "status" => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
    /* public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'mobile' => 'required',
        'mobile' => 'required',
        "pin_code" => 'required',
        "pan_card" => 'required',
        "date_of_birth" => 'required',
        "company" => 'required',
        "field_of_work" => 'required',
        "designation" => 'required',
        "monthly_salary" => 'required',
        "monthly_emi" => 'required',
        "load_type" => 'required',
        "load_amount" => 'required',
        "mode_of_salary" => 'required',
        "load_purpose" => 'required',
    ]; */    

}
