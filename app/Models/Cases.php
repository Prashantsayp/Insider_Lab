<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use App\Models\Agents;
use App\Models\Products;

/**
 * Class Cases
 * @package App\Models
 * @version September 3, 2020, 3:22 pm UTC
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 */
class Cases extends Model
{
    use SoftDeletes;

    public $table = 'cases';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'mobile',
        "pin_code",
        "pan_card",
        "date_of_birth",
        "company",
        "field_of_work",
        "designation",
        "monthly_salary",
        "monthly_emi",
        "load_type",
        "load_amount",
        "mode_of_salary",
        "salary_bank",
        "load_purpose",
        "assigned_to",
        "created_by",
        "status",
        "selected_loan",
        "loan_period",
        "email",
        "new_otp",
        "product_otp",
        "gender",
        "marital_status",
        "past_loans",
        "aadhar_card",
        "aadhar_card_number",
        "pan_card_number",
        "address_type",
        "residential_status",
        "ongoing_monthly_obligations",
        "work_experience",
        "exp_with_current_employer",
        "highest_degree",
        "years_in_business",
        "total_loans",
        "employer_name",
        "firm_name",
        "occupation",
        "employment_type",
        "organisation_type",
        "industry",
        "working_from_home",
        "premise_ownership_status",
        "inform_client_income",
        "primary_account",
        "case_login_date",
        "bank_login_date",
        "disbursed_amount",
        "disbursed_interest_rate",
        "final_emi",
        "disbursed_tenure",
        "agent_payout",
        "insiderlab_payout",
        "account_holder_name",
        "account_number",
        "ifsc_code",
        "address",
        "business_industry",
        "how_old_business",
        "business_health",
        "profitability_years",
        "cibil",
        "case_status",
        "status_explanation",
        "eligibility_status",
        "case_status_comment",
        "final_loan_loan_amount",
        "final_loan_interest_rate",
        "final_loan_tenure",
        "final_loan_processing_fees",
        "selected_loan",
        "status_date",
        "income_method"
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


    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . " " . ucfirst($this->last_name);
    }

    public function getPanCardAttribute($panCard)
    {
        if (isset($panCard)) {
            $s3 = Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getClient();
            $expiry = "+15 minutes";

            $command = $client->getCommand('GetObject', [
                'Bucket' => env("AWS_BUCKET"),
                'Key'    => env('AWS_SECRET_ACCESS_KEY')
            ]);

            $request = $client->createPresignedRequest($command, $expiry);

            return (string) $request->getUri();
            //            return (string) "";
            // $storage = $disk->put($this->pan_card, $fileData, 'private');
        }
    }


   


    public function agents()
    {       
        return $this->belongsTo(Agents::class, 'created_by');
       //return $this->hasMany(Categories::class,'caste_category_id');       
    }

    public function Customers()
    {
        return $this->belongsTo(\App\Models\Customers::class, 'customer_id');
    }

    
    public function documentList()
    {
        return $this->hasMany(\App\Models\Documents::class);
    }
    public function productList()
    {
       // return $this->hasMany(\App\Models\Products::class,'id');
       return $this->hasMany('App\Models\Products', 'id', 'selected_loan');
    }

}
