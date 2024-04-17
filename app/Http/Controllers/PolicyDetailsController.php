<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Illuminate\Http\Request;
use App\Models\PolicyDetails;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PolicyDetailsRepository;
use App\Http\Requests\CreatePolicyDetailsRequest;
use App\Http\Requests\UpdatePolicyDetailsRequest;

class PolicyDetailsController extends AppBaseController
{
    /** @var  PolicyDetailsRepository */
    private $policyDetailsRepository;

    public function __construct(PolicyDetailsRepository $policyDetailsRepo)
    {
        $this->policyDetailsRepository = $policyDetailsRepo;
    }

    /**
     * Display a listing of the PolicyDetails.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $policyDetails = $this->policyDetailsRepository->all();

        return view('policy_details.index')
            ->with('policyDetails', $policyDetails);
    }

    /**
     * Show the form for creating a new PolicyDetails.
     *
     * @return Response
     */
    public function create()
    {
        return view('policy_details.create');
    }

    /**
     * Store a newly created PolicyDetails in storage.
     *
     * @param CreatePolicyDetailsRequest $request
     *
     * @return Response
     */
    public function store(CreatePolicyDetailsRequest $request)
    {
        $input = $request->all();

        $policyDetails = $this->policyDetailsRepository->create($input);

        Flash::success('Policy Details saved successfully.');

        return redirect(route('policyDetails.index'));
    }

    /**
     * Display the specified PolicyDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $policyDetails = $this->policyDetailsRepository->find($id);

        if (empty($policyDetails)) {
            Flash::error('Policy Details not found');

            return redirect(route('policyDetails.index'));
        }

        return view('policy_details.show')->with('policyDetails', $policyDetails);
    }

    /**
     * Show the form for editing the specified PolicyDetails.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $policyDetails = $this->policyDetailsRepository->find($id);

        if (empty($policyDetails)) {
            Flash::error('Policy Details not found');

            return redirect(route('policyDetails.index'));
        }

        return view('policy_details.edit')->with('policyDetails', $policyDetails);
    }

    /**
     * Update the specified PolicyDetails in storage.
     *
     * @param int $id
     * @param UpdatePolicyDetailsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePolicyDetailsRequest $request)
    {
        $policyDetails = $this->policyDetailsRepository->find($id);

        if (empty($policyDetails)) {
            Flash::error('Policy Details not found');

            return redirect(route('policyDetails.index'));
        }

        $policyDetails = $this->policyDetailsRepository->update($request->all(), $id);

        Flash::success('Policy Details updated successfully.');

        return redirect(route('policyDetails.index'));
    }

    /**
     * Remove the specified PolicyDetails from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $policyDetails = $this->policyDetailsRepository->find($id);

        if (empty($policyDetails)) {
            Flash::error('Policy Details not found');

            return redirect(route('policyDetails.index'));
        }

        $this->policyDetailsRepository->delete($id);

        Flash::success('Policy Details deleted successfully.');

        return redirect(route('policyDetails.index'));
    }

    public function evaluate() {
        return view("policy_details.evaluate");
    }



    public function getDetails (Request $request)
    {
        $policies = ["1" => "HDFC", "2" => "IDFC"];
        foreach ($policies as $key => $policy) {

            $policyDetails = PolicyDetails::where("policy_id", $key)->orderBy("linked_condition_key")->orderBy("condition_value", "asc")->get();
            $fFConditions = [];
            foreach ($policyDetails as $pdk => $policyDetail ) {
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

            echo "<br />rate of interest is " ;

            $policyDetailsObj = new PolicyDetails();
            $policyLists =
            $allParents = $policyDetailsObj->getAllParentConditions($key);
            $irr = 0;
            $foir = 0;
            $input = $request->all();
            $output = [];
            try {
                foreach ($allParents as $policyKey => $policyVal) {
                    try {
                        if ($policyVal->childrens->count() == 0) {
                            if ($policyVal->condition == "equals_to") {
                                if ($input[$policyVal->linked_condition_key] == $policyVal->condition_value) {
                                    $output[$policyVal->calculation_field] = $policyVal->final_value;
                                }
                            }
                            if ($policyVal->condition == "in_range") {
                                list($min, $max) = explode(",", $policyVal->condition_value);
                                if (($input[$policyVal->linked_condition_key] > $min) && ($input[$policyVal->linked_condition_key] < $max)) {
                                    $output[$policyVal->calculation_field] = $policyVal->final_value;
                                }
                            }
                            if ($policyVal->condition == "greater_than_equals_to") {
                                if ($input[$policyVal->linked_condition_key] >= $policyVal->final_value) {
                                    $output[$policyVal->calculation_field] = $policyVal->final_value;
                                }
                            }
                        } else {
                            $output[$policyVal->calculation_field] = $policyDetailsObj->calculateFinalParent($policyVal, $input);
                        }
                    } catch (\Exception $ex) {
                        Log::error('Error', [$ex]);
                        continue;
                    }

                }
            } catch (\Exception $e) {
                Log::error('Error' , [$e]);
            }

            $loanAmount = ($request->salary - ($request->salary * ($output["foir"]/100)) - $request->obligations) * $request->tenure;
            $monthlyIRR = $output["irr"] / 12;
            // $emi = ($loanAmount * ($monthlyIRR / 100) * ( pow((1 + ($monthlyIRR / 100)),$request->tenure )) ) / (pow((1 + ($monthlyIRR / 100)), ($request->tenure - 1))  ) ;
            $emi = $this->calPMT($output["irr"], $request->tenure, $loanAmount);
            echo "Policy Name: " . $policy;
            echo json_encode([$output, "loan_amount" => $loanAmount, "emi" => $emi]);
        }
        dd();
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
