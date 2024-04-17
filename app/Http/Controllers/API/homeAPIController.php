<?php

namespace App\Http\Controllers\API;

use JWTAuth;
use Response;
use Exception;
use App\Models\home;
use App\Models\User;
use App\Repositories\ProductsRepository;
use App\Models\Cases;
use App\Models\Products;
use App\Models\BankDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\homeRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatehomeAPIRequest;
use App\Http\Requests\API\UpdatehomeAPIRequest;

/**
 * Class homeController
 * @package App\Http\Controllers\API
 */
class homeAPIController extends AppBaseController
{
    /** @var  homeRepository */
    private $homeRepository;

    public function __construct(homeRepository $homeRepo)
    {
        $this->homeRepository = $homeRepo;
    }

    /**
     * Display a listing of the home.
     * GET|HEAD /homes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Unauthorized",
                    "show_message" => true
                ], 404);
            }
            $returnArray = [];
            // $casesByUser = Cases::with("selectedLoan")->select("first_name", "last_name", "status")->where([["created_by", "=", $user->id]])->orderBy("created_at", "desc")->get();
            // Log::info('Project', [$user]);
            $casesByUser = Cases::with("documentList")->whereNotNull("first_name")->whereNotNull("last_name")->whereNotNull("pin_code")->where([["created_by", "=", $user->id]])->orderBy("created_at", "desc")->get();
            Log::info('Cases By User', [$casesByUser]);
            foreach ($casesByUser as $case) {
                $temp = $case->toArray();
                if (isset($temp["selected_loan"])) {
                    $product = Products::where([["id", "=", $temp["selected_loan"]]])->first();
                    if (isset($product) && isset($product->name)) {
                        $bankDetails = BankDetails::where([["id", "=", $product->bank_id]])->first();
                        $temp["product_name"] = $product->name;
                        $temp["bank_name"] = $bankDetails->name; //$case->selectedLoan->bank_name,;
                    } else {
                        $temp["product_name"] = "Product Not Selected";
                    }
                } else {
                    $temp["product_name"] = "Product Not Selected";
                }
                if(empty($case->case_status)){
                    $case->case_status = "Select Loan Product";
                }
                $temp["loan_amount"] = $case->load_amount;
                $temp["name"] = $case->full_name;
                $temp["status"] = $case->status;
                $temp["case_status"] = $case->case_status;
                $temp["payment_status"] = "unpaid";
                $returnArray[] = $temp;
            }
            Log::info('User::', [$user]);
            return response()->json([
                "error" => 0,
                "message" => "Details fetched Successfully",
                "data" => [
                    "agentID" => $user->id,
                    "agentName" => $user->name,
                    "customerList" => $returnArray
                ],
                "show_message" => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => $e->getMessage(),
                "show_message" => true,
                "data" => []
            ]);
        }
    }

    public function pincode(Request $request)
    {
    }

    public function get_agent_name(Request $request)
    {
        try {
            if (!isset($request->agent_id)) {
                return response()->json([
                    "error" => 1,
                    "message" => "Required parameter agent_id missing.",
                    "show_message" => true
                ]);
            }

            if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
                return response()->json([
                    "error" => 1,
                    "message" => "Unauthorized.",
                    "show_message" => true
                ], 401);
            }

            $agent = User::find($request->agent_id);
            if (isset($agent)) {
                return response()->json([
                    "error" => 0,
                    "message" => "Details fetched Successfully",
                    "data" => [
                        "agentID" => $agent->id,
                        "agentName" => $agent->name,
                        "location" => $agent->location,
                    ],
                    "show_message" => false
                ], 200);
            } else {
                return response()->json([
                    "error" => 1,
                    "message" => "Invalid AgentID",
                    "show_message" => true
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ], 401);
        }
    }

    public function get_all_products(Request $request)
    {
        //        $products = ProductsRepository::all(
        //            $request->except(['skip', 'limit']),
        //            $request->get('skip'),
        //            $request->get('limit')
        //        );
        $products = Products::get();
        $opArray = [];
        if (count($products) > 0) {
            foreach ($products as $productKey => $product) {
                if (isset($product->features) && isset($product->features["page_setup"])) {
                    $opArray[$productKey] = $product->toArray();
                    foreach ($product->features["page_setup"] as $key => $page) {
                        $opArray[$productKey]["features"]["page_setup"][$key] = htmlspecialchars_decode($page);
                    }
                }
            }
        }
        return response()->json([
            "error" => 0,
            "data" => $opArray,
            "message" => "Products fetched successfully.",
            "show_message" => false
        ]);
        // return $this->sendResponse(ProductsResource::collection($products), 'Products retrieved successfully');
    }

    public function product_details($id)
    {
        /** @var Products $products */
        $products = Products::find($id);

        if (empty($products)) {
            return response()->json([
                "error" => 1,
                "message" => "No product found.",
                "data" => [],
                "show_message" => false
            ]);
        }
        $opArray = [];
        //Log::info("___PRODUCT___", [$products]);
        if (isset($products->features) && isset($products->features["page_setup"])) {
            $opArray = $products->toArray();
            foreach ($products->features["page_setup"] as $key => $page) {
                $opArray["features"]["page_setup"][$key] = htmlspecialchars_decode($page);
            }
        }
        return response()->json([
            "error" => 0,
            "data" => $opArray,
            "message" => "Products fetched successfully.",
            "show_message" => false
        ]);
        // return $this->sendResponse(new ProductsResource($products), 'Products retrieved successfully');
    }
}
