<?php

namespace App\Http\Controllers\API;

use Flash;
use Response;
use App\Models\Cases;
use App\Models\Products;
use App\Helpers\AllHelper;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Models\ProfessionalPolicyDetails;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ProfessionalPolicyDetailsRepository;
use App\Http\Requests\CreateProfessionalPolicyDetailsRequest;
use App\Http\Requests\UpdateProfessionalPolicyDetailsRequest;

class ProfessionalPolicyDetailsAPIController extends AppBaseController
{
    /** @var  ProfessionalPolicyDetailsRepository */
    private $professionalPolicyDetailsRepository;

    public function __construct(ProfessionalPolicyDetailsRepository $professionalPolicyDetailsRepo)
    {
        $this->professionalPolicyDetailsRepository = $professionalPolicyDetailsRepo;
    }

    /**
     * Display a listing of the ProfessionalPolicyDetails.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->all();

        return view('professional_policy_details.index')
            ->with('professionalPolicyDetails', $professionalPolicyDetails);
    }

    /**
     * Show the form for creating a new ProfessionalPolicyDetails.
     *
     * @return Response
     */
    public function create()
    {
        return view('professional_policy_details.create');
    }

    /**
     * Store a newly created ProfessionalPolicyDetails in storage.
     *
     * @param CreateProfessionalPolicyDetailsRequest $request
     *
     * @return Response
     */
    public function store(CreateProfessionalPolicyDetailsRequest $request)
    {
        $input = $request->all();

        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->create($input);

        Flash::success('Professional Policy Details saved successfully.');

        return redirect(route('professionalPolicyDetails.index'));
    }

    /**
     * Display the specified ProfessionalPolicyDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->find($id);

        if (empty($professionalPolicyDetails)) {
            Flash::error('Professional Policy Details not found');

            return redirect(route('professionalPolicyDetails.index'));
        }

        return view('professional_policy_details.show')->with('professionalPolicyDetails', $professionalPolicyDetails);
    }

    /**
     * Show the form for editing the specified ProfessionalPolicyDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->find($id);

        if (empty($professionalPolicyDetails)) {
            Flash::error('Professional Policy Details not found');

            return redirect(route('professionalPolicyDetails.index'));
        }

        return view('professional_policy_details.edit')->with('professionalPolicyDetails', $professionalPolicyDetails);
    }

    /**
     * Update the specified ProfessionalPolicyDetails in storage.
     *
     * @param int $id
     * @param UpdateProfessionalPolicyDetailsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProfessionalPolicyDetailsRequest $request)
    {
        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->find($id);

        if (empty($professionalPolicyDetails)) {
            Flash::error('Professional Policy Details not found');

            return redirect(route('professionalPolicyDetails.index'));
        }

        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->update($request->all(), $id);

        Flash::success('Professional Policy Details updated successfully.');

        return redirect(route('professionalPolicyDetails.index'));
    }

    /**
     * Remove the specified ProfessionalPolicyDetails from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $professionalPolicyDetails = $this->professionalPolicyDetailsRepository->find($id);

        if (empty($professionalPolicyDetails)) {
            Flash::error('Professional Policy Details not found');

            return redirect(route('professionalPolicyDetails.index'));
        }

        $this->professionalPolicyDetailsRepository->delete($id);

        Flash::success('Professional Policy Details deleted successfully.');

        return redirect(route('professionalPolicyDetails.index'));
    }

    public function evaluate()
    {
        return view("policy_details.evaluate");
    }


    public function getDetails(Request $request)
    {
        $products = Products::where([["type", "=", "professional"]])->get();
        foreach ($products as $productKey => $policy) {
            $key = $policy->id;
            $policyDetails = ProfessionalPolicyDetails::where("policy_id", $key)->orderBy("linked_condition_key")->orderBy("condition_value", "asc")->get();
            $fFConditions = [];
            foreach ($policyDetails as $pdk => $policyDetail) {
                $fFConditions[$policyDetail->calculation_field][$policyDetail->linked_condition_key][$policyDetail->condition][] = [
                    "final_value" => $policyDetail->final_value,
                    "linked_condition_key" => $policyDetail->linked_condition_key,
                    "condition" => $policyDetail->condition,
                    "condition_value" => $policyDetail->condition_value,
                    'policy_id' => $policyDetail->policy_id,
                    'condition_type' => $policyDetail->condition_type,
                    'parent_condition_id' => $policyDetail->parent_condition_id,
                    'parent_condition_value' => $policyDetail->parent_condition_value,
                    "calculation_field" => $policyDetail->calculation_field
                ];
            }

            // echo json_encode($fFConditions);

            // echo "<br />rate of interest is ";

            $policyDetailsObj = new ProfessionalPolicyDetails();
            $policyLists = $allParents = $policyDetailsObj->getAllParentConditions($key);
            $irr = 0;
            $foir = 0;
            $input = $request->all();
            // echo json_encode($input);
            $output = [];
            // echo json_encode($allParents);
            try {
                foreach ($allParents as $policyKey => $policyVal) {
                    try {
                        // echo json_encode($policyVal);
                        if ($policyVal->childrens->count() == 0) {
                            if ($policyVal->condition == "equals_to") {
                                if ($input[$policyVal->linked_condition_key] == $policyVal->condition_value) {
                                    $output[$policy->id][$policyVal->calculation_field] = $policyVal->final_value;
                                }
                            }
                            if ($policyVal->condition == "in_range") {
                                list($min, $max) = explode(",", $policyVal->condition_value);
                                if (($input[$policyVal->linked_condition_key] > $min) && ($input[$policyVal->linked_condition_key] < $max)) {
                                    $output[$policy->id][$policyVal->calculation_field] = $policyVal->final_value;
                                }
                            }
                            if ($policyVal->condition == "greater_than_equals_to") {
                                if ($input[$policyVal->linked_condition_key] >= $policyVal->final_value) {
                                    $output[$policy->id][$policyVal->calculation_field] = $policyVal->final_value;
                                }
                            }
                        } else {
                            $output[$policy->id][$policyVal->calculation_field] = $policyDetailsObj->calculateFinalParent($policyVal, $input);
                            // echo json_encode($policyDetailsObj->calculateFinalParent($policyVal, $input));
                        }
                    } catch (\Exception $ex) {
                        Log::error('Error', [$ex]);
                        continue;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error', [$e]);
            }
            // $loanAmount = ($request->salary - ($request->salary * ($output["foir"] / 100)) - $request->obligations) * $request->tenure;
            // $monthlyIRR = $output["irr"] / 12;
            // // $emi = ($loanAmount * ($monthlyIRR / 100) * ( pow((1 + ($monthlyIRR / 100)),$request->tenure )) ) / (pow((1 + ($monthlyIRR / 100)), ($request->tenure - 1))  ) ;
            // $emi = $this->calPMT($output["irr"], $request->tenure, $loanAmount);
            // echo "Policy Name: " . $policy;
            echo json_encode([$output]);
            if (isset($output["receipt_program"]) && $output["receipt_program"] == "A" ) {
                $rp = ($request->salary * 2) - ($request->obligations * 12);
                echo "Receipt Program: " .$rp ;
            } else if (isset($output["receipt_program"]) && $output["receipt_program"] == "NA" && !isset($output["foir"])) {
                // $rp = ($request->salary * 2) - ($request->obligations * 12);
                echo "Receipt Program: " . $input["loan_amount"];
            }
            if (isset($output["cash_profit_program"]) && $output["cash_profit_program"] == "A") {
                $rp = (($request->salary + 50000) * 4)- ($request->obligations * 12);
                echo "Cash Profit Program: " . $rp;
            } else if (isset($output["cash_profit_program"]) && $output["cash_profit_program"] == "NA" && !isset($output["foir"])) {
                // $rp = ($request->salary * 2) - ($request->obligations * 12);
                echo "Cash Profit Program: " . $input["loan_amount"];
            }

        }
        dd();
    }

    public function getAnalytics (Request $request ) {
        try  {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Unauthorized",
                    "show_message" => true
                ], 401);
            }
            $json["error"] = 0;
            $json["message"] = "Successfully retrieved data";
            $json["show_message"] = true;
            $case = Cases::find($request->case_id);
            if (!$case) {
                $json["error"] = 1;
                $json["message"] = "Case not found";
                $json["show_message"] = true;
                return response()->json($json);
            }
            $products = Products::get();

            foreach ($products as $keyProduct => $product) {
                 //echo "<pre>"; print_r($product);exit;
                // ui_listing
                $kHelper = new AllHelper();
                if (isset($product->features["ui_setup"])) {
                    $emi = $kHelper->calculateEMI($case->load_amount, $product->features["ui_setup"]["irr"], $case->loan_period);
                    $emi = round($emi);
                    $json["data"][$product->id]["product_name"] = $product->name;
                    $json["data"][$product->id]["emi"] = $emi;
                    foreach ($product->ui_listing["page_setup"] as $k => $pageData) {
                        $unprocessedData = htmlspecialchars_decode($pageData);
                        $processing_fees = ($case->load_amount * $product->features["ui_setup"]["processing_fees"]) / 100;
                        $unprocessedData = str_replace("{{analytics_loan_amount}}", $case->load_amount, $unprocessedData);
                        $unprocessedData = str_replace("{{desired_loan_amount}}", $case->load_amount, $unprocessedData);
                        $unprocessedData = str_replace("{{max_analytics_loan_amount}}", $case->load_amount, $unprocessedData);
                        $unprocessedData = str_replace("{{analytics_rate_of_interest}}", $product->features["ui_setup"]["irr"], $unprocessedData);
                        $unprocessedData = str_replace("{{analytics_emi}}", $emi, $unprocessedData);
                        $unprocessedData = str_replace("{{desired_tenure}}", $case->loan_period, $unprocessedData);
                        $unprocessedData = str_replace("{{analytics_processing_fees}}", $processing_fees, $unprocessedData);
                        $json["data"][$product->id]["ui_listing"][$k] = @$unprocessedData;
                        $json["data"][$product->id]["page_setup"][$k] = @$unprocessedData;
                    }
                }

            }            

        } catch (\Exception $e) {
            Log::info('Exception', [$e]);
            $json["error"] = 1;
            $json["message"] = "Retrieving data failed";
        }
        return response()->json($json);

    }



    /**
     * @param float $apr   Interest rate.
     * @param integer $term  Loan length in months.
     * @param float $loan  The loan amount.
     */

    public function calPMT($apr, $term, $loan)
    {
        $apr = $apr / 1200;
        $amount = $apr * -$loan * pow((1 + $apr), $term) / ((1 - pow((1 + $apr), $term)) == 0) ? 1 : (1 - pow((1 + $apr), $term));
        return round($amount);
    }
}
