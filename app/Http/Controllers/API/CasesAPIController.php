<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use JWTAuth;
use Response;
use App\Models\Cases;
use App\Models\Products;
use App\Models\BankDetails;
use App\Models\Comments;
use App\Models\CaseActions;
use App\Models\CaseStatus;
use App\Models\EligibilityStatus;
use App\Models\UploadDocumentType;
use App\Models\CaseFinalBankApproval;
use App\Models\MediaNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CasesResource;
use App\Repositories\CasesRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateCasesAPIRequest;
use App\Http\Requests\API\UpdateCasesAPIRequest;

/**
 * Class CasesController
 * @package App\Http\Controllers\API
 */

class CasesAPIController extends AppBaseController
{
    /** @var  CasesRepository */
    private $casesRepository;

    public function __construct(CasesRepository $casesRepo)
    {
        $this->casesRepository = $casesRepo;
    }

    /**
     * Display a listing of the Cases.
     * GET|HEAD /cases
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        /*echo '<pre>';
		print_r($request);
		exit;*/
		if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        $cases = Cases::with("documentList")->with("productList")->whereNotNull("first_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
		 //echo "<pre>";print_r($cases->toArray());exit;
		/*Rameshwar : removing the conditional check of not null last name*/
        //$cases = Cases::with("documentList")->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();

        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Cases fetched successfully.", "data" => $cases]);
    }

    /**
     * Store a newly created Cases in storage.
     * POST /cases
     *
     * @param CreateCasesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCasesAPIRequest $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        try {
            $input = $request->all();
            $input["created_by"] = $user->id;
            $date = Carbon::now()->format('Y-m-d');
            Log::info("Case Request $date: ", $input);
            $cases = $this->casesRepository->create($input);

            return response()->json([
                "error" => 0,
                "message" => "Case saved successfully",
                "data" => $cases,
                "show_message" => true
            ]);
        } catch (\Exception $e) {
            Log::info('Error', [$e]);
            return response()->json([
                "error" => 1,
                "message" => "Something Went Wrong",
                "debug" => [$e],
                "show_message" => true
            ]);
        }
    }

    /**
     * Display the specified Cases.
     * GET|HEAD /cases/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Cases $cases */
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 401);
        }
        $cases = Cases::with("documentList")->where([["id", "=", $id], ["created_by", "=", $user->id]])->first();

        // $cases = $this->casesRepository->find($id);
        if (empty($cases)) {
            return response()->json(["error" => 0, "message" => "No Cases Found.", "data" => []]);
        }

        $documentList = $cases->documentList;

        Log::info("___Document List ____", [$documentList]);
        $temp = $cases->toArray();
        Log::info("___TEMP ____", [$temp]);
        if (isset($temp["selected_loan"])) {
            $product = Products::where([["id", "=", $temp["selected_loan"]]])->first();
            if (isset($product) && isset($product->name)) {
                $bankDetails = BankDetails::where([["id", "=", $product->bank_id]])->first();
                $temp["product_name"] = $product->name;
                $temp["bank_name"] = $bankDetails->name; //$cases->selectedLoan->bank_name,;
            } else {
                $temp["product_name"] = "Product Not Selected";
            }
        } else {
            $temp["product_name"] = "Product Not Selected";
        }
        if (isset($temp["client_income"])) {
            $temp["monthly_salary"] = $temp["client_income"];
        }
         if(empty($cases->case_status)){
                    $cases->case_status = "Select Loan Product";
                }
        $temp["loan_amount"] = $cases->load_amount;
        $temp["name"] = $cases->full_name;
        $temp["status"] = $cases->status;
         $temp["case_status"] = $cases->case_status;
        $temp["payment_status"] = "unpaid";
        $temp["date_of_birth"] = Carbon::parse($cases->date_of_birth)->addDay(1)->format('Y-m-d');
        // $returnArray[] = $temp;



        return response()->json(["error" => 0, "message" => "Case fetched successfully.", "data" => $temp]);
    }

    /**
     * Update the specified Cases in storage.
     * PUT/PATCH /cases/{id}
     *
     * @param int $id
     * @param UpdateCasesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCasesAPIRequest $request)
    {
        $input = $request->all();
        Log::info('All Input Data', [$input]);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 401);
        }
        /** @var Cases $cases */
        $cases = Cases::where([["id", "=", $id], ["created_by", "=", $user->id]])->first();

        if (empty($cases)) {
            return response()->json(["error" => 1, "message" => "Case Not found.", "data" => [], "show_message" => true]);
        }

        /**
        'gender': gender,
        'marital_status': maritalStatus,
        'past_loans': pastLoans,
        'aadhar_card': aadharCard,
        'aadhar_card_number': aadharCardNumber,
        'pan_card': panCard,
        'pan_card_number': panCardNumber,
        'email': emailID,
        'mobile': mobileNumber,
        'pin_code': pinCode,
        'date_of_birth': dob,
        'address_type': addressType,
        'residential_status': residentialStatus,
        'load_amount': loanAmount,
        'load_type': loanType,
        'mode_of_salary': mode,
        'ongoing_monthly_obligations': ongoingMonthlyObligation,
        'monthly_salary': monthlySalary,
        'work_experience': workExp,
        'exp_with_current_employer': expCurrentEmployer,
        'highest_degree': highestDegree,
        'years_in_business': yearsInBusiness,
        'total_loans': totalLoans,
        'load_purpose': purposeOfLoan,
        'employer_name': companyName,
        'firm_name': firmName,
        'tenure': tenure,
        'occupation': occupation,
        'employment_type': employmentType,
        'organisation_type': organisationType,
        'industry': industry,
        'working_from_home': workingFromHome,
        'premise_ownership_status': ownershipStatus,
        'inform_client_income': informClientIncome,
        'primary_account': primaryAccount
         */
        if (isset($input["primaryAccount"])) {
            $input["primary_account"] =  $input["primaryAccount"];
        }
        if (isset($input["informClientIncome"])) {
            $input["inform_client_income"] =  $input["informClientIncome"];
        }
        if (isset($input["ownershipStatus"])) {
            $input["premise_ownership_status"] =  $input["ownershipStatus"];
        }
        if (isset($input["workingFromHome"])) {
            $input["working_from_home"] =  $input["workingFromHome"];
        }
        if (isset($input["industry"])) {
            $input["industry"] =  $input["industry"];
        }
        if (isset($input["organisationType"])) {
            $input["organisation_type"] =  $input["organisationType"];
        }
        if (isset($input["employmentType"])) {
            $input["employment_type"] =  $input["employmentType"];
        }
        if (isset($input["occupation"])) {
            $input["occupation"] =  $input["occupation"];
        }
        if (isset($input["tenure"])) {
            $input["tenure"] =  $input["tenure"];
        }
        if (isset($input["firmName"])) {
            $input["firm_name"] =  $input["firmName"];
        }
        if (isset($input["companyName"])) {
            $input["employer_name"] =  $input["companyName"];
        }
        if (isset($input["purposeOfLoan"])) {
            $input["load_purpose"] =  $input["purposeOfLoan"];
        }
        if (isset($input["totalLoans"])) {
            $input["total_loans"] =  $input["totalLoans"];
        }
        if (isset($input["yearsInBusiness"])) {
            $input["years_in_business"] =  $input["yearsInBusiness"];
        }
        if (isset($input["highestDegree"])) {
            $input["highest_degree"] =  $input["highestDegree"];
        }
        if (isset($input["expCurrentEmployer"])) {
            $input["exp_with_current_employer"] =  $input["expCurrentEmployer"];
        }
        if (isset($input["workExp"])) {
            $input["work_experience"] =  $input["workExp"];
        }
        if (isset($input["monthlySalary"])) {
            $input["monthly_salary"] =  $input["monthlySalary"];
        }
        if (isset($input["ongoingMonthlyObligation"])) {
            $input["ongoing_monthly_obligations"] =  $input["ongoingMonthlyObligation"];
        }
        if (isset($input["mode"])) {
            $input["mode_of_salary"] =  $input["mode"];
        }
        if (isset($input["loanType"])) {
            $input["load_type"] =  $input["loanType"];
        }
        if (isset($input["loanAmount"])) {
            $input["load_amount"] =  $input["loanAmount"];
        }
        if (isset($input["residentialStatus"])) {
            $input["residential_status"] =  $input["residentialStatus"];
        }
        if (isset($input["addressType"])) {
            $input["address_type"] =  $input["addressType"];
        }
        if (isset($input["dob"])) {
            $input["date_of_birth"] =  $input["dob"];
        }
        if (isset($input["pinCode"])) {
            $input["pin_code"] =  $input["pinCode"];
        }
        if (isset($input["mobileNumber"])) {
            $input["mobile"] =  $input["mobileNumber"];
        }
        if (isset($input["emailID"])) {
            $input["email"] =  $input["emailID"];
        }
        if (isset($input["panCardNumber"])) {
            $input["pan_card_number"] =  $input["panCardNumber"];
        }
        if (isset($input["panCard"])) {
            $input["pan_card"] =  $input["panCard"];
        }
        if (isset($input["aadharCardNumber"])) {
            $input["aadhar_card_number"] =  $input["aadharCardNumber"];
        }
        if (isset($input["aadharCard"])) {
            $input["aadhar_card"] =  $input["aadharCard"];
        }
        if (isset($input["pastLoans"])) {
            $input["past_loans"] = $input["pastLoans"];
        }
        if (isset($input["gender"])) {
            $input["gender"] = $input["gender"];
        }
        if (isset($input["maritalStatus"])) {
            $input["marital_status"] = $input["maritalStatus"];
        }
        if (isset($input["full_name"])) {
            $name = explode(" ", $input["full_name"]);
            $input["first_name"] = $name[0];
            if (is_array($name) && isset($name[1]))
                $input["last_name"] = end($name);
        }
        if (isset($input["tenure"])) {
            $input["loan_period"] = $input["tenure"];
        }
        if (isset($input["primary_account"])) {
            $input["salary_bank"] = $input["primary_account"];
        }
        if (isset($input["employment_type"])) {
            if ($input["employment_type"] == "Salaried - Doctor/CA/CS") {
                $input["employment_type"] = "salaried";
            }
            if ($input["employment_type"] == "Self Employed - Doctor/CA/CS") {
                $input["employment_type"] = "self_employed";
            }
            if ($input["employment_type"] == "Salaried + Self-Employed - Doctor") {
                $input["employment_type"] = "salaried_plus_self_employed";
            }
            if ($input["employment_type"] == "Self Employed - Other Professional") {
                $input["employment_type"] = "self_employed";
            }
        }
        $cases = $this->casesRepository->update($input, $id);

        return response()->json(["error" => 0, "message" => "Case updated successfully.", "data" => $cases, "show_message" => true]);
    }

    /**
     * Remove the specified Cases from storage.
     * DELETE /cases/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Cases $cases */
        $cases = $this->casesRepository->find($id);

        if (empty($cases)) {
            return $this->sendError('Cases not found');
        }

        $cases->delete();

        return $this->sendSuccess('Cases deleted successfully');
    }

    /**
     * This function mark the status of the case as submitted
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function submit(Request $request, $id)
    {
        $cases = $this->casesRepository->find($id);
        //$cases->status = "Not Selected";
        $cases->case_status = "Verifying Eligibility";
        $cases->save();
        if ($cases->case_status == "Verifying Eligibility") {
            return response()->json([
                "error" => 0,
                "message" => "Case status successfully updated.",
                "show_message" => true,
                "data" => $cases
            ]);
        } else {
            return response()->json([
                "error" => 1,
                "message" => "Unable to update case status.",
                "show_message" => true,
                "data" => $cases
            ]);
        }
    }

//=====================New API For Update=======================================
	public function caseCreate(CreateCasesAPIRequest $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        try {
            $input = $request->all();
            //print_r($input);exit; 
            $input["created_by"] = $user->id;

        if($user->id){
            $input["case_status"] = "New - Select Loan Product";
            $input["status"] = "Not Required";
        }   
        if (isset($input["primaryAccount"])) {
            $input["primary_account"] =  $input["primaryAccount"];
        }
        if (isset($input["cibil"])) {
            $input["cibil"] = $input["cibil"];
        }
        if (isset($input["address"])) {
            $input["address"] = $input["address"];
        }
        if (isset($input["informClientIncome"])) {
            $input["inform_client_income"] =  $input["informClientIncome"];
        }
        if (isset($input["income_method"])) {
            $input["income_method"] =  $input["income_method"];
        }
        if (isset($input["income_method"])) {
            $input["income_method"] =  $input["income_method"];
        }
        if (isset($input["ownershipStatus"])) {
            $input["premise_ownership_status"] =  $input["ownershipStatus"];
        }
        if (isset($input["workingFromHome"])) {
            $input["working_from_home"] =  $input["workingFromHome"];
        }
        if (isset($input["industry"])) {
            $input["industry"] =  $input["industry"];
        }
        if (isset($input["organisationType"])) {
            $input["organisation_type"] =  $input["organisationType"];
        }
        if (isset($input["employmentType"])) {
            $input["employment_type"] =  $input["employmentType"];
        }
        if (isset($input["occupation"])) {
            $input["occupation"] =  $input["occupation"];
            $input["designation"] =  $input["occupation"];
        }
        if (isset($input["business_industry"])) {
            $input["business_industry"] =  $input["business_industry"];
        }
        
        // if (isset($input["tenure"])) {
        //     $input["tenure"] =  $input["tenure"];
        // }
        if (isset($input["firmName"])) {
            $input["firm_name"] =  $input["firmName"];
            $input["company"] =  $input["firmName"];
        }
        
        if (isset($input["field_of_work"])) {
            $input["field_of_work"] =  $input["field_of_work"];
        }
        if (isset($input["companyName"])) {
            $input["employer_name"] =  $input["companyName"];
        }
        if (isset($input["purposeOfLoan"])) {
            $input["load_purpose"] =  $input["purposeOfLoan"];
        }
        if (isset($input["totalLoans"])) {
            $input["total_loans"] =  $input["totalLoans"];
        }
        if (isset($input["yearsInBusiness"])) {
            $input["years_in_business"] =  $input["yearsInBusiness"];
        }
        if (isset($input["highestDegree"])) {
            $input["highest_degree"] =  $input["highestDegree"];
        }
        if (isset($input["expCurrentEmployer"])) {
            $input["exp_with_current_employer"] =  $input["expCurrentEmployer"];
        }
        if (isset($input["workExp"])) {
            $input["work_experience"] =  $input["workExp"];
        }
        if (isset($input["monthlySalary"])) {
            $input["monthly_salary"] =  $input["monthlySalary"];
        }
        if (isset($input["ongoingMonthlyObligation"])) {
            $input["ongoing_monthly_obligations"] =  $input["ongoingMonthlyObligation"];
        }
        if (isset($input["mode"])) {
            $input["mode_of_salary"] =  $input["mode"];
        }
        if (isset($input["loanType"])) {
            $input["load_type"] =  $input["loanType"];
        }
        if (isset($input["loanAmount"])) {
            $input["load_amount"] =  $input["loanAmount"];
        }
        if (isset($input["monthly_emi"])) {
            $input["monthly_emi"] =  $input["monthly_emi"];
        }
        if (isset($input["residentialStatus"])) {
            $input["residential_status"] =  $input["residentialStatus"];
        }
        if (isset($input["addressType"])) {
            $input["address_type"] =  $input["addressType"];
        }
        if (isset($input["dob"])) {
            $input["date_of_birth"] =  $input["dob"];
        }
        if (isset($input["pinCode"])) {
            $input["pin_code"] =  $input["pinCode"];
        }
        if (isset($input["mobileNumber"])) {
            $input["mobile"] =  $input["mobileNumber"];
        }
        if (isset($input["emailID"])) {
            $input["email"] =  $input["emailID"];
        }
        if (isset($input["panCardNumber"])) {
            $input["pan_card_number"] =  $input["panCardNumber"];
        }
        if (isset($input["panCard"])) {
            $input["pan_card"] =  $input["panCard"];
        }
        if (isset($input["aadharCardNumber"])) {
            $input["aadhar_card_number"] =  $input["aadharCardNumber"];
        }
        if (isset($input["aadharCard"])) {
            $input["aadhar_card"] =  $input["aadharCard"];
        }
        if (isset($input["pastLoans"])) {
            $input["past_loans"] = $input["pastLoans"];
        }
        if (isset($input["gender"])) {
            $input["gender"] = $input["gender"];
        }
        if (isset($input["maritalStatus"])) {
            $input["marital_status"] = $input["maritalStatus"];
        }
        if (isset($input["full_name"])) {
            $name = explode(" ", $input["full_name"]);
            $input["first_name"] = $name[0];
            $input["last_name"] = $name[1];
        }
        // if (isset($input["full_name"])) {
        //     $input["full_name"] = $input["full_name"];
        // }
        // if (isset($input["full_name"])) {
        //     $input["full_name"] = $input["full_name"];
        // }
        
        if (isset($input["tenure"])) {
            $input["loan_period"] = $input["tenure"];
        }
        if (isset($input["primary_account"])) {
            $input["salary_bank"] = $input["primary_account"];
        }
        
        if (isset($input["employment_type"])) {
            // if ($input["employment_type"] == "Salaried - Doctor/CA/CS") {
            //     $input["employment_type"] = "salaried";
            // }
            // if ($input["employment_type"] == "Self Employed - Doctor/CA/CS") {
            //     $input["employment_type"] = "self_employed";
            // }
            // if ($input["employment_type"] == "Salaried + Self-Employed - Doctor") {
            //     $input["employment_type"] = "salaried_plus_self_employed";
            // }
            // if ($input["employment_type"] == "Self Employed - Other Professional") {
            //     $input["employment_type"] = "self_employed";
            // }
            $input["employment_type"] =  $input["employment_type"];
        }
        //print_r($input);exit;
            $date = Carbon::now()->format('Y-m-d');
            Log::info("Case Request $date: ", $input);

           //$cases = $this->casesRepository->create($input);
            
            if($cases = Cases::create($input)){

                return response()->json([
                    "error" => 0,
                    "message" => "Case saved successfully",
                    "data" => $cases,
                    "show_message" => true
                ]);
            }else{
                 Log::info('Error', [$e]);
                return response()->json([
                    "error" => 1,
                    "message" => "Something Went Wrong",
                    "debug" => [$e],
                    "show_message" => true
                ]);
            }

          //  echo 'Vijay';
          //  exit;
            
        } catch (\Exception $e) {
            Log::info('Error', [$e]);
            return response()->json([
                "error" => 1,
                "message" => "Something Went Wrong",
                "debug" => [$e],
                "show_message" => true
            ]);
        }
    }
	public function updateCases($id=null, UpdateCasesAPIRequest $request)
    {
        $input = $request->all();
		$id= $request->id;
		//print_r($input);exit;
        Log::info('All Input Data', [$input]);
         if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 401);
        } 
        /** @var Cases $cases */
        $cases = Cases::where([["id", "=", $id], ["created_by", "=", $user->id]])->first();

        if (empty($cases)) {
            return response()->json(["error" => 1, "message" => "Case Not found.", "data" => [], "show_message" => true]);
        }

        if (isset($input["status"])) {
            $input["case_status"] =  $input["case_status"];
            $input["status"] =  $input["status"];
        }else{
            $input["case_status"] = "New - Select Loan Product";
            $input["status"] = "Not Required";
        }
        if (isset($input["primaryAccount"])) {
            $input["primary_account"] =  $input["primaryAccount"];
        }
        if (isset($input["premise_ownership_status"])) {
            $input["premise_ownership_status"] =  $input["premise_ownership_status"];
        }
        if (isset($input["cibil"])) {
            $input["cibil"] = $input["cibil"];
        }
        if (isset($input["address"])) {
            $input["address"] = $input["address"];
        }
        if (isset($input["informClientIncome"])) {
            $input["inform_client_income"] =  $input["informClientIncome"];
        }
        if (isset($input["income_method"])) {
            $input["income_method"] =  $input["income_method"];
        }
        if (isset($input["income_method"])) {
            $input["income_method"] =  $input["income_method"];
        }
        if (isset($input["ownershipStatus"])) {
            $input["premise_ownership_status"] =  $input["ownershipStatus"];
        }
        if (isset($input["workingFromHome"])) {
            $input["working_from_home"] =  $input["workingFromHome"];
        }
        if (isset($input["industry"])) {
            $input["industry"] =  $input["industry"];
        }
        if (isset($input["organisationType"])) {
            $input["organisation_type"] =  $input["organisationType"];
        }
       
        if (isset($input["occupation"])) {
            $input["occupation"] =  $input["occupation"];
            $input["designation"] =  $input["occupation"];
        }
        if (isset($input["business_industry"])) {
            $input["business_industry"] =  $input["business_industry"];
        }
        
        // if (isset($input["tenure"])) {
        //     $input["tenure"] =  $input["tenure"];
        // }
        if (isset($input["firmName"])) {
            $input["firm_name"] =  $input["firmName"];
            $input["company"] =  $input["firmName"];
        }
        
        if (isset($input["field_of_work"])) {
            $input["field_of_work"] =  $input["field_of_work"];
        }
        if (isset($input["companyName"])) {
            $input["employer_name"] =  $input["companyName"];
        }
        if (isset($input["purposeOfLoan"])) {
            $input["load_purpose"] =  $input["purposeOfLoan"];
        }
        if (isset($input["totalLoans"])) {
            $input["total_loans"] =  $input["totalLoans"];
        }
        if (isset($input["yearsInBusiness"])) {
            $input["years_in_business"] =  $input["yearsInBusiness"];
        }
        if (isset($input["highestDegree"])) {
            $input["highest_degree"] =  $input["highestDegree"];
        }
        if (isset($input["expCurrentEmployer"])) {
            $input["exp_with_current_employer"] =  $input["expCurrentEmployer"];
        }
        if (isset($input["workExp"])) {
            $input["work_experience"] =  $input["workExp"];
        }
        if (isset($input["monthlySalary"])) {
            $input["monthly_salary"] =  $input["monthlySalary"];
        }
        if (isset($input["ongoingMonthlyObligation"])) {
            $input["ongoing_monthly_obligations"] =  $input["ongoingMonthlyObligation"];
        }
        if (isset($input["mode"])) {
            $input["mode_of_salary"] =  $input["mode"];
        }
        if (isset($input["loanType"])) {
            $input["load_type"] =  $input["loanType"];
        }
        if (isset($input["loanAmount"])) {
            $input["load_amount"] =  $input["loanAmount"];
        }
        if (isset($input["monthly_emi"])) {
            $input["monthly_emi"] =  $input["monthly_emi"];
        }
        if (isset($input["residentialStatus"])) {
            $input["residential_status"] =  $input["residentialStatus"];
        }
        if (isset($input["addressType"])) {
            $input["address_type"] =  $input["addressType"];
        }
        if (isset($input["dob"])) {
            $input["date_of_birth"] =  $input["dob"];
        }
        if (isset($input["pinCode"])) {
            $input["pin_code"] =  $input["pinCode"];
        }
        if (isset($input["mobileNumber"])) {
            $input["mobile"] =  $input["mobileNumber"];
        }
        if (isset($input["emailID"])) {
            $input["email"] =  $input["emailID"];
        }
        if (isset($input["panCardNumber"])) {
            $input["pan_card_number"] =  $input["panCardNumber"];
        }
        if (isset($input["panCard"])) {
            $input["pan_card"] =  $input["panCard"];
        }
        if (isset($input["aadharCardNumber"])) {
            $input["aadhar_card_number"] =  $input["aadharCardNumber"];
        }
        if (isset($input["aadharCard"])) {
            $input["aadhar_card"] =  $input["aadharCard"];
        }
        if (isset($input["pastLoans"])) {
            $input["past_loans"] = $input["pastLoans"];
        }
        if (isset($input["gender"])) {
            $input["gender"] = $input["gender"];
        }
        if (isset($input["maritalStatus"])) {
            $input["marital_status"] = $input["maritalStatus"];
        }
        if (isset($input["full_name"])) {
            $name = explode(" ", $input["full_name"]);
            $input["first_name"] = $name[0];
            $input["last_name"] = $name[1];
        }
        // if (isset($input["full_name"])) {
        //     $input["full_name"] = $input["full_name"];
        // }
        // if (isset($input["full_name"])) {
        //     $input["full_name"] = $input["full_name"];
        // }
        
        if (isset($input["tenure"])) {
            $input["loan_period"] = $input["tenure"];
        }
        if (isset($input["primary_account"])) {
            $input["salary_bank"] = $input["primary_account"];
        }
        
        if (isset($input["employment_type"])) {            
            $input["employment_type"] =  $input["employment_type"];
        }
       
        if($cases = $this->casesRepository->update($input, $id)){
            $document_type_aadhar = UploadDocumentType::where([["document_type", "=", 'Aadhar Card'],["case_id", "=", $cases->id]])->first();
            //print_r($document_type_aadhar->toArray());exit;
            if(empty($document_type_aadhar)){
                $input["status"] = "Yes";
                $input["comments"] = "You Can Upload Document";
                $input["document_type"] = "Aadhar Card";
                $input["case_id"] = $cases->id;
                UploadDocumentType::create($input);
            }
            $document_type_pan = UploadDocumentType::where([["document_type", "=", 'Pan Card'],["case_id", "=", $cases->id]])->first();
            if(empty($document_type_pan)){
                $input["status"] = "Yes";
                $input["comments"] = "You Can Upload Document";
                $input["document_type"] = "Pan Card";
                $input["case_id"] = $cases->id;
                UploadDocumentType::create($input);
            } 

                if($cases->load_type == 'Business'){
                    $document_type_perma = UploadDocumentType::where([["document_type", "=", 'Permanent Address Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_perma)){
                    $input["status"] = "Yes";
                    $input["comments"] = "You Can Upload Document";
                    $input["document_type"] = "Permanent Address Proof";
                    $input["case_id"] = $cases->id;
                    UploadDocumentType::create($input);
                    }
                    $document_type_pers = UploadDocumentType::where([["document_type", "=", 'Present Address Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_pers)){
                    $input["status"] = "Yes";
                    $input["comments"] = "You Can Upload Document";
                    $input["document_type"] = "Present Address Proof";
                    $input["case_id"] = $cases->id;
                    UploadDocumentType::create($input);
                    }

                    $document_type_busiProp = UploadDocumentType::where([["document_type", "=", 'Business Property Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_busiProp)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Business Property Proof";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_busiCont = UploadDocumentType::where([["document_type", "=", 'Business Continuity Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_busiCont)){
                         $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Business Continuity Proof";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_incom = UploadDocumentType::where([["document_type", "=", 'Income Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_incom)){
                         $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Income Proof";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_busiBank = UploadDocumentType::where([["document_type", "=", 'Business Bank Statment'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_busiBank)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Business Bank Statment";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }
                     $document_type_gstReturn = UploadDocumentType::where([["document_type", "=", 'GST Return'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_gstReturn)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "GST Return";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                   
                }

                if($cases->load_type == 'Personal'){

                     $document_type_perma = UploadDocumentType::where([["document_type", "=", 'Permanent Address Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_perma)){
                    $input["status"] = "Yes";
                    $input["comments"] = "You Can Upload Document";
                    $input["document_type"] = "Permanent Address Proof";
                    $input["case_id"] = $cases->id;
                    UploadDocumentType::create($input);
                    }
                    $document_type_pers = UploadDocumentType::where([["document_type", "=", 'Present Address Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_pers)){
                    $input["status"] = "Yes";
                    $input["comments"] = "You Can Upload Document";
                    $input["document_type"] = "Present Address Proof";
                    $input["case_id"] = $cases->id;
                    UploadDocumentType::create($input);
                    }

                    $document_type_sal = UploadDocumentType::where([["document_type", "=", 'Salary Slip'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_sal)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Salary Slip";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_busiBank = UploadDocumentType::where([["document_type", "=", 'Salary Bank Statement'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_busiBank)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Salary Bank Statement";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }
                     $document_type_form16 = UploadDocumentType::where([["document_type", "=", 'Form 16'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_form16)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Form 16";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_oficial_id = UploadDocumentType::where([["document_type", "=", 'Official ID Card'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_oficial_id)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Official ID Card";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }
                    
                }
                if($cases->load_type == 'Professional'){

                     $document_type_perma = UploadDocumentType::where([["document_type", "=", 'Permanent Address Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_perma)){
                    $input["status"] = "Yes";
                    $input["comments"] = "You Can Upload Document";
                    $input["document_type"] = "Permanent Address Proof";
                    $input["case_id"] = $cases->id;
                    UploadDocumentType::create($input);
                    }
                    $document_type_pers = UploadDocumentType::where([["document_type", "=", 'Present Address Proof'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_pers)){
                    $input["status"] = "Yes";
                    $input["comments"] = "You Can Upload Document";
                    $input["document_type"] = "Present Address Proof";
                    $input["case_id"] = $cases->id;
                    UploadDocumentType::create($input);
                    }

                    $document_type_sal = UploadDocumentType::where([["document_type", "=", 'Salary Slip'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_sal)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Salary Slip";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_busiBank = UploadDocumentType::where([["document_type", "=", 'Salary Bank Statement'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_busiBank)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Salary Bank Statement";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }
                     $document_type_form16 = UploadDocumentType::where([["document_type", "=", 'Form 16'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_form16)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Form 16";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_oficial_id = UploadDocumentType::where([["document_type", "=", 'Official ID Card'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_oficial_id)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Official ID Card";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    $document_type_degree = UploadDocumentType::where([["document_type", "=", 'Highest Degree Qualification'],["case_id", "=", $cases->id]])->first();
                    if(empty($document_type_degree)){
                        $input["status"] = "Yes";
                        $input["comments"] = "You Can Upload Document";
                        $input["document_type"] = "Highest Degree Qualification";
                        $input["case_id"] = $cases->id;
                        UploadDocumentType::create($input);
                    }

                    

                    
                }

        }
        return response()->json(["error" => 0, "message" => "Case updated successfully.", "data" => $cases, "show_message" => true]);
    }

    public function updateLoanProduct($id=null, UpdateCasesAPIRequest $request)
    {
        $input = $request->all();
        $id= $request->id;
        //print_r($input);exit;
        Log::info('All Input Data', [$input]);
         if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 401);
        } 
        /** @var Cases $cases */
        $cases = Cases::where([["id", "=", $id], ["created_by", "=", $user->id]])->first();

        if (empty($cases)) {
            return response()->json(["error" => 1, "message" => "Case Not found.", "data" => [], "show_message" => true]);
        }
      
        $input["selected_loan"] =  $input["loan_selected_id"];
        $input["case_status"] = "New - Upload Documents";
        //$input["status"] = "Not Selected";
        
        $cases = $this->casesRepository->update($input, $id);

        return response()->json(["error" => 0, "message" => "Case updated successfully.", "data" => $cases, "show_message" => true]);
    }
    public function getCaseStatus(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        //$case_status = Cases::select("status",'id','first_name','last_name')->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
		
		/*Sujay : removing the conditional check of not null last name*/
		$case_status = Cases::select("status",'id','first_name','last_name')->whereNotNull("first_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
        
        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Cases fetched successfully.", "data" => $case_status]);
    }

    public function eligibilityStatus(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        //$case_status = Cases::select("status",'id','first_name','last_name')->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
        
        /*Sujay : removing the conditional check of not null last name*/

        $eligibility_status = EligibilityStatus::select("status",'id','explanation')->where([["case_id", "=", $request->case_id]])->first();
        //echo "<pre>"; print_r($eligibility_status->toarray());exit;
        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Eligibility Status fetched successfully.", "data" => $eligibility_status]);
    }

    public function finalLoanApprovalCase(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        //$case_status = Cases::select("status",'id','first_name','last_name')->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
        
        /*Sujay : removing the conditional check of not null last name*/

        $loan_approval = CaseFinalBankApproval::select('id',"loan_amount",'interest_rate','tenure','processing_fees')->where([["case_id", "=", $request->case_id]])->first();
        //echo "<pre>"; print_r($eligibility_status->toarray());exit;
        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Final Loan Approval fetched successfully.", "data" => $loan_approval]);
    }

    public function commentCaseList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        //$case_status = Cases::select("status",'id','first_name','last_name')->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
        
        /*Sujay : removing the conditional check of not null last name*/

        $comments = Comments::select('*')->where([["case_id", "=", $request->case_id]])->get()->toArray();
        //echo "<pre>"; print_r($comments);exit;
        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Comments fetched successfully.", "data" => $comments]);
    }

    public function documentCaseList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }        

        $documentTypeList = UploadDocumentType::select('*')->where([["case_id", "=", $request->case_id],["status", "=", 'Yes']])->get()->toArray();
        //echo "<pre>"; print_r($comments);exit;
        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Comments fetched successfully.", "data" => $documentTypeList]);
    }


    public function commentsSent($id=null, Request $request)
    {
        $input = $request->all();
        $id= $request->id;
        //print_r($input);exit;
        Log::info('All Input Data', [$input]);
         if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 401);
        } 
        /** @var Cases $cases */
        $cases = Cases::where([["id", "=", $id], ["created_by", "=", $user->id]])->first();

        if (empty($cases)) {
            return response()->json(["error" => 1, "message" => "Case Not found.", "data" => [], "show_message" => true]);
        }
      
        $comments = Comments::create(['case_id' => $id, 'case_comments' => $request->case_comments]);

        return response()->json(["error" => 0, "message" => "Comment Sent successfully.", "data" => $comments, "show_message" => true]);
    }

    public function finalCaseList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        //$case_status = Cases::select("status",'id','first_name','last_name')->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->get();
        
        /*Sujay : removing the conditional check of not null last name*/
        $case_status = Cases::select('id',"case_status","status","status_explanation","eligibility_status","final_loan_loan_amount","final_loan_interest_rate","final_loan_tenure","final_loan_processing_fees",'first_name','last_name')->whereNotNull("first_name")->whereNotNull("last_name")->where([["id", "=", $request->id]])->get();
        
        // return $this->sendResponse(CasesResource::collection($cases), 'Cases retrieved successfully');
        return response()->json(["error" => 0, "message" => "Cases fetched successfully.", "data" => $case_status]);
    }

    public function mediaPageNotification(Request $request)
    {   
        
    if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        $media = MediaNotifications::whereNotNull("tag")->whereNotNull("send")->get();    
        
        return response()->json(["error" => 0, "message" => "Media Notification fetched successfully.", "data" => $media]);
    }

    public function getAllStatus(Request $request)
    {   
        
    if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        $status = CaseStatus::whereNotNull("title")->get();    
        
        return response()->json(["error" => 0, "message" => "Status fetched successfully.", "data" => $status]);
    }
    public function getAllActions(Request $request)
    {   
        
    if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                "error" => 1,
                "message" => "User Unauthorized",
                "show_message" => true
            ], 404);
        }
        $Actions = CaseActions::whereNotNull("actions")->get();    
        
        return response()->json(["error" => 0, "message" => "Actions fetched successfully.", "data" => $Actions]);
    }
}
