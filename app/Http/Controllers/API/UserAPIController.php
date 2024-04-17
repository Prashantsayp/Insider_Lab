<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use JWTAuth;
use Response;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cases;
use App\Models\Agents;
use GuzzleHttp\Client;

use App\Models\Products;
// use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Models\QuestionAnswer;
use App\Models\UserController;
use App\Helpers\MobileIntractions;
use App\Models\MobileVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client as OClient;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\AppBaseController;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * Class UserControllerController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    public function authenticate(Request $request)
    {
        try {

            if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
                return response()->json([
                    "error" => 1,
                    "message" => "Unauthorized.",
                    "show_message" => true
                ], 401);
            }

            if (!isset($request->email) || !isset($request->password)) {
                return response()->json([
                    "error" => 1,
                    "message" => "Required parameters email or password missing.",
                    "show_message" => true
                ]);
            }
            $u = User::where([["email", "=", $request->email]])->first();
            if (!isset($u) && !isset($u->email)) {
                return response()->json([
                    "error" => 1,
                    "message" => "User not found.",
                    "show_message" => true
                ]);
            }
            $credentials = $request->only('email', 'password');

            $credentials["disabled"] = $u->disabled;
            if (!$u->disabled) {
                return response()->json([
                    "error" => 1,
                    "message" => "Account not enabled. Please contact customer care.",
                    "show_message" => true
                ]);
            }
            // Log::info("####Credentials", [$credentials]);
            // Log::info("### BCRYPT PASSEORD", [bcrypt($credentials["password"])]);
            // Log::info("HASH CHECK", [Hash::check($credentials["password"], $u->password )]);
            try {
                // $credentials["password"] = bcrypt($credentials["password"]);
                // $credentials = request(['email', 'password']);

                // if (! $token = auth()->attempt($credentials)) {
                //     return response()->json(['error' => 'Unauthorized'], 401);
                // }

                // return $this->respondWithToken($token);
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        "error" => 1,
                        "message" => "Invalid credentials.",
                        "show_message" => true
                    ], 400);
                }
            } catch (JWTException $e) {
                Log::error('JWT Error', [$e]);
                return response()->json([
                    "error" => 1,
                    "message" => "Could not create token.",
                    "show_message" => true
                ], 500);
            }

            $agent = Agents::where([["email", "=", $request->email]])->first();
            $agent->firebase_token = $request->firebase_token == '' ? $agent->firebase_token : $request->firebase_token;
            $agent->save();

            return response()->json([
                "error" => 0,
                "message" => "Token Generated Successfully",
                "data" => [
                    "token" => $token
                ],
                "show_message" => false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Following error occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function register($id, Request $request)
    {

        try {
            if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
                return response()->json([
                    "error" => 1,
                    "message" => "Unauthorized.",
                    "show_message" => true
                ], 401);
            }
            $user = Agents::where([["id", "=", $id]])->first();
            if (!isset($user) && !isset($user->id)) {
                return response()->json([
                    "error" => 0,
                    "message" => "Agent not found",
                    "show_message" => true
                ]);
            }
            $input = $request->all();
            Log::info('Agent Input', [$user, $input]);

            try {
                if (isset($input["name"])) {
                    $user->name = $input["name"];
                }
                if (isset($input["password"])) {
                    $user->password = bcrypt($input["password"]);
                }
                if (isset($input["pan_card"])) {
                    $user->pan_card = $input["pan_card"];
                }
                if (isset($input["aadhar_card"])) {
                    $user->aadhar_card = $input["aadhar_card"];
                }
                if (isset($input["email"])) {
                    $user->email = $input["email"];
                }
                if (isset($input["mobile"])) {
                    $user->mobile = $input["mobile"];
                }
                if (!isset($user->mobile_verified_at)) {
                    $user->mobile_verified_at = Carbon::now();
                }
                if (!isset($user->email_verified_at)) {
                    $user->email_verified_at = Carbon::now();
                }
                if (isset($input["location"])) {
                    $user->location = $input["location"];
                }
                if (isset($input["account_holder_name"])) {
                    $user->account_holder_name = $input["account_holder_name"];
                }
                if (isset($input["ifsc_code"])) {
                    $user->ifsc_code = $input["ifsc_code"];
                }
                if (isset($input["account_number"])) {
                    $user->account_number = $input["account_number"];
                }
                if (isset($input["dob"])) {
                    $user->dob = $input["dob"];
                }
                if (isset($input["gender"])) {
                    $user->gender = $input["gender"];
                }
                if (isset($input["bank_name"])) {
                    $user->bank_name = $input["bank_name"];
                }
                if (isset($input["current_profession"])) {
                    $user->current_profession = $input["current_profession"];
                }
                if (isset($input["employment_type"])) {
                    $user->employment_type = $input["employment_type"];
                }
                if (isset($input["work_experience"])) {
                    $user->work_experience = $input["work_experience"];
                }
                if (isset($input["employer_name"])) {
                    $user->employer_name = $input["employer_name"];
                }
                if (isset($input["financial_industry"])) {
                    $user->financial_industry = $input["financial_industry"];
                }
                if (isset($input["hold_gov_office"])) {
                    $user->hold_gov_office = $input["hold_gov_office"];
                } 
                if (isset($input["firebase_token"])) {
                    $user->firebase_token = $input["firebase_token"];
                }  
               
                $user->user_type = "agent";
                $user->save();
            } catch (\Exception $e) {
                Log::error('message');
                Log::info('Agent Input', [$e]);
            }
            // $user = User::create([
            //     'name' => $request->get('name'),
            //     'email' => $request->get('email'),
            //     'password' => Hash::make($request->get('password')),
            //     'location' => $request->get('location'),
            //     'aadhar_card' => $request->get('aadhar_card'),
            //     'pan_card' => $request->get('pan_card'),
            //     'mobile' =>  $request->get('mobile'),
            //     'mobile_verified_at' => Carbon::now()
            // ]);

            // $token = JWTAuth::fromUser($user);

            return response()->json([
                "error" => 0,
                "message" => "Registered Successfully",
                "data" => [
                    "user" => $user
                ],
                "show_message" => false
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function getAuthenticatedUser(Request $request)
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
                    "message" => "User Not Found.",
                    "show_message" => true
                ], 404);
            }
        } catch (TokenExpiredException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Expired.",
                "show_message" => true
            ], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Invalid Token.",
                "show_message" => true
            ], $e->getCode());
        } catch (JWTException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Not Found",
                "show_message" => true
            ], $e->getCode());
        }

        return response()->json([
            "error" => 0,
            "message" => "User Authenticated Successfully",
            "data" => [
                "user" => $user
            ],
            "show_message" => false
        ]);
    }

    public function sendOTP(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        try {
            $json = [];
            Log::info('All Data', [$request]);
            $mobile = $request->email;
           // print_r($mobile);exit;
            if ($request->type == "agent") {
                $mobileVerificationEnabled = MobileVerification::where([["mobile_number", "=", $mobile], ["is_verified", "=", 1]])->first();
                if (isset($mobileVerificationEnabled) && isset($mobileVerificationEnabled->mobile_number)) {
					
					//added new code start
					$user = User::where([["email", "=", $mobileVerificationEnabled->mobile_number], ["user_type", "=", "agent"]])->first();
					if (isset($user->name) && isset($user->mobile)) {
						Log::info('The given Email is already active.', [$mobileVerificationEnabled]);
						return response()->json([
							"error" => 1,
							"message" => "The given Email is already active."
						]);
					}//added new code end
					
                    /*Log::info('The given Email is already active.', [$mobileVerificationEnabled]);
                    return response()->json([
                        "error" => 1,
                        "message" => "The given Email is already active."
                    ]);*/
                }
            }
            $mobileIntraction = new MobileIntractions();
            $otp  = $mobileIntraction->createOTP($request->type);
            $message = "{$otp} is the OTP to create your account with Insider Lab. And is valid for 20 minutes";
            $subjectLine = "OTP for new registration with Insider Labs";
            if ($request->type == "agent") {
                $agentWithSameMobile = Agents::where([["mobile", "=", $mobile]])->first();
                if (isset($agentWithSameMobile) && isset($agentWithSameMobile->mobile_number)) {
                    Log::info("User with same mobile number already exists.", [$agentWithSameMobile]);
                    return response()->json([
                        "error" => 1,
                        "message" => "User with same mobile number already exists.",
                        "show_message" => true
                    ]);
                }
            }
            if ($request->type == "case") {
                if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json([
                        "error" => 1,
                        "message" => "User Unauthorized",
                        "show_message" => true
                    ], 401);
                }
                //                $case = Cases::where([["email", "=", $request->email]])->first();
                //                if (isset($case) && isset($case->id)) {
                //                    return response()->json([
                //                        "error" => 1,
                //                        "message" => "User with same mobile number already exists.",
                //                        "show_message" => true
                //                    ]);
                //                }
                //                $message = "{$otp} is the OTP to create your account with Insider Labs. And is valid for 20 minutes";
                $message = '<!DOCTYPE html><html><head><body style="color: rgb(255, 255, 255); background-color: rgb(32, 49, 78);padding: 25px;"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title></title></head><p style="text-align: left;"><img style="width: 200px;" src="http://crm.insiderlab.in/logo.jpeg"></p><p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">Hello,<br><br><br></p>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">We at InsiderLab have received your interest for Loan application from ' . $user->name . '  [User Id : ' . $user->id . '], your Financial Therapist.</p>
<div style="color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><br></div>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">Insiderlab is a financial services distribution company, founded in 2020 to make customer onboarding easy for Lending institutes, by improving the experience of compare, select & buy financial services products.  </p>
<div style="color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><br></div>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">We have also been on the other side, and from understanding our customer we have created <strong>Customer Empathy Document</strong> to help you better navigate with us and what you should do when interacted with any of our Financial Therapist. </p>
<div style="color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><br></div>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong>Please provide your consent for the usage of personal information by sharing the below OTP to ' . $user->name . ' [User Id : ' . $user->id . ']</strong></p>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><br></strong></p>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><span style="font-size: 30px;color: #f4de4c;">' . $otp . '</span></strong></p>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><br></p>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">Click here to go through our<a href="https://www.insiderlab.in/app-terms-component.html" rel="noopener noreferrer" target="_blank"><span style="color: rgb(255, 255, 255);"> Terms &amp; Condition  </span></a>and<a href="https://www.insiderlab.in/app-privacy-component" rel="noopener noreferrer" target="_blank"><span style="color: rgb(255, 255, 255);"> Privacy Policy</span></a></p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">The personal information and documents (Name, Address, KYCs, Income, obligation, etc.) that would be provided by you to ' . $user->name . ' [User Id : ' . $user->id . '], will be used in our system to perform eligibility analytics and screening, to suggest you with best Financial products matching your requirement. </p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);">Contact us on +918810600135 or <a href="mailto:support@insiderlab.in" rel="noreferrer" style="color: rgb(255 255 255);" target="_blank">support@insiderlab.in</a> for any discussion, doubts or queries.</p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: #20314E;"><strong style="color: white; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;"><span lang="EN-US">Disclaimer</span></strong><span lang="EN-US" style="color: white; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; ; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">: You must NOTE here, we are not a CIBIL platform (yet). So, we will not run your CIBIL score.&nbsp;</span><span lang="EN-GB" style="color: rgb(0, 0, 0); font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;"><br></span><em style="color: white; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;"><span lang="EN-US">After you have selected any financial product through our platform, our service desk member would connect with you over the phone to learn more about your needs and confirm your selection to proceed with your loan application. At the time, as you would give us the heads-up to proceed, we would generate your CIBIL on your selected financial institute&rsquo;s platform or inform the financial institute to proceed your application (after they receive all your documents), whereby they would go through your complete eligibility screening including CIBIL check.</span></em></p><p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><br></strong></p><p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><br></strong></p><p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><br></strong></p>
  <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong>Thanks,</strong></p>
  <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><br></strong></p>
  <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong>Service Team,</strong></p>
  <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><br></p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><span lang="EN-US" style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; font-size: 9pt; font-family: Helvetica; color: white;">InsiderLab Fintech Pvt. Ltd.&nbsp;</span><span lang="EN-GB" style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; font-size: 9pt; font-family: Helvetica; color: black;"><br></span><span lang="EN-US" style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; font-size: 9pt; font-family: Helvetica; color: white;"><a data-saferedirecturl="https://www.google.com/url?q=http://www.insiderlab.in&source=gmail&ust=1617822018203000&usg=AFQjCNGQotxCC2F5uWk4Jt7ziG2CTQNfpQ" href="http://www.insiderlab.in/" rel="noreferrer" style="color: white;" target="_blank"><span style="color: white;">www.insiderlab.in</span></a><br>Registered Office : 1603/1 RTO Road South Civil Lines, Jabalpur, Madhya Pradesh, 482001<br>Branch Office : Office A4 Sai Heritage Commercial (LGF) Plot No. 22, Sector 14, Kaushambhi</span>&nbsp;</strong></p>
  </body>
</html>';
                //                $message = "Hi $case->first_name,
                //
                //
                //We at InsiderLab have received your interest for the Loan from $user->name, your Financial Therapist.
                //
                //
                //
                //We are a financial services distribution company, founded in 2020 with the vision to empower every Indian with the access to financial services.
                //
                //Yes, we are young, and energized to give right value to our community. Help in becoming better with your suggestions, feedbacks or complains. Visit us at www.insiderlab.in/customer and write to us about your experience with $user->name and Insiderlab.
                //
                //
                //The personal information and documents (Name, Address, KYCs, Income, obligation, etc.) that would be provided by you to $user->name, will be used in our system to perform eligibility analytics and screening, to suggest you with best Financial products matching your requirement. Kindly go through the complete General Terms of Use and our Privacy Policy to learn more about our business practice and data management standards – www.insiderlab.in
                //
                //
                //Please provide the below OTP to $user->name to provide your consent for the usage of personal information.
                //
                //
                //								$otp
                //
                //
                //You must NOTE here, we are not a CIBIL platform (yet). So, we will not run your CIBIL score.
                //
                //After you have selected any financial product through our platform, our service desk member would connect with you over the phone to learn more about your needs and confirm your selection to proceed with your loan application. At the time, as you would give us the heads-up to proceed, we would generate your CIBIL on your selected financial institute’s platform or inform the financial institute to proceed your application (after they receive all your documents), whereby they would go through your complete eligibility screening including CIBIL check.
                //
                //
                //
                //Contact us on +918810600135 or support@insiderlab.in for any discussion, doubts or queries.
                //
                //
                //
                //Thanks,
                //
                //InsiderLab Fintech Pvt. Ltd.
                //
                //Rgtd Address: 1603/1 RTO Road, South Civil Lines, Jabalpur, MP, 482001";
                $subjectLine = "OTP for Loan application with InsiderLab";
                $case = new Cases();
                $case->email = $request->email;
                $case->created_by = $user->id;
                $case->new_otp = $otp;
                $case->save();
                $json["case"]["id"] = $case->id;
            }

            if ($request->type == "product_selection") {
                if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json([
                        "error" => 1,
                        "message" => "User Unauthorized",
                        "show_message" => true
                    ], 401);
                }
                if (!isset($request->case_id)) {
                    return response()->json([
                        "error" => 1,
                        "message" => "Case id is mandatory",
                        "show_message" => true
                    ]);
                }

                $subjectLine = "OTP to confirm Financial Product selection with InsiderLab";
                $case = Cases::find($request->case_id);
                $product = Products::where([["id", "=", $request->product_id]])->first();
                //                $message = "{$otp} is the OTP to select '{$product->name}'. With a total value of Rs. {$case->load_amount} with Insider Labs. And is valid for 20 minutes";
                $message = '<!DOCTYPE html><html><head><body style="color: rgb(255, 255, 255); background-color: rgb(32, 49, 78);padding: 25px;"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title></title></head><p style="text-align: left;"><img style="width: 200px;" src="http://crm.insiderlab.in/logo.jpeg"></p>
    <p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff">Hi ' . $case->first_name . ',&nbsp;</p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><br>Good to be in your Inbox again!</p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><br></p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff">We have received your selection of loan product by ' . $user->name . '  [User Id : ' . $user->id . '] on InsiderLab platform. The details of selected product are&nbsp;</p>
<table border="1" cellpadding="0" cellspacing="0" style="color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;background-color: rgb(32, 49, 78);border-collapse: collapse;border: none;">
    <tbody>
        <tr>
            <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;margin: 0px;width: 233.75pt;border: 1pt solid white;padding: 0cm 5.4pt;vertical-align: top;" valign="top" width="50%">
                <p style="margin: 0px 0px 0cm;line-height: normal;">Lender Name&nbsp;</p>
            </td>
            <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;margin: 0px;width: 233.75pt;border-top: 1pt solid white;border-right: 1pt solid white;border-bottom: 1pt solid white;border-left-style: none;padding: 0cm 5.4pt;vertical-align: top;" valign="top" width="50%">
                <div style="margin-bottom: 0cm;line-height: normal;"> ' . $product->name . '</div>
            </td>
        </tr>
        <tr>
            <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;margin: 0px;width: 233.75pt;border-right: 1pt solid white;border-bottom: 1pt solid white;border-left: 1pt solid white;border-top-style: none;padding: 0cm 5.4pt;vertical-align: top;" valign="top" width="50%">
                <p style="margin: 0px 0px 0cm;line-height: normal;">Loan Amount</p>
            </td>
            <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;margin: 0px;width: 233.75pt;border-style: none solid solid none;border-bottom-width: 1pt;border-bottom-color: white;border-right-width: 1pt;border-right-color: white;padding: 0cm 5.4pt;vertical-align: top;" valign="top" width="50%">
                <div style="margin-bottom: 0cm;line-height: normal;">' . $case->load_amount . '</div>
            </td>
        </tr>
        <tr>
            <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;margin: 0px;width: 233.75pt;border-right: 1pt solid white;border-bottom: 1pt solid white;border-left: 1pt solid white;border-top-style: none;padding: 0cm 5.4pt;vertical-align: top;" valign="top" width="50%">
                <p style="margin: 0px 0px 0cm;line-height: normal;">Tenure</p>
            </td>
            <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;margin: 0px;width: 233.75pt;border-style: none solid solid none;border-bottom-width: 1pt;border-bottom-color: white;border-right-width: 1pt;border-right-color: white;padding: 0cm 5.4pt;vertical-align: top;" valign="top" width="50%">
                <div style="margin-bottom: 0cm;line-height: normal;">' . $case->loan_period . ' Months</div>
            </td>
        </tr>
    </tbody>
</table>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><br></p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><strong>Please provide the below OTP to the ' . $user->name . '  [User Id : ' . $user->id . '] validating your product selection.</strong></p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><br></p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><strong><span style="font-size: 30px;color: #f4de4c;">' . $otp . '</span></strong></p>
<div style="font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><br></div>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff">We hope all your questions were addressed, and you were able to make informed selection decision.</p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff">If you still feel the need for detailed discussion which would build more trust for you to confirm this selection,&nbsp;</p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff">reach out to us at <a href="mailto:admin@insiderlab.in" rel="noreferrer" style="color: #fff;" target="_blank">admin@insiderlab.in</a> or call us on +918810600135 between 10am – 6pm Monday – Friday; 10am – 2pm Saturday – Sunday</p>
<div style="font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff">&nbsp;</div>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><em>** Please note, the product details and availability of financial product is tentative and restricted to the personal information provided by you as of now. The actual product details and availability will be share to you after the CIBIL calculation and evaluation of your application by your selected lender. <br><br>**Please be assured that you&rsquo;re all the documented data is safe with us and will be purged after the case completion.</em></p>
<p style="margin: 0px;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78); color: #ffffff"><strong><br></strong></p>
<p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong>Thanks,</strong></p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><br></strong></p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong>Service Team,</strong></p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><br></p>
    <p style="margin: 0px;color: #ffffff;font-family: Arial, Helvetica, sans-serif;font-size: small;font-style: normal;font-weight: 400;text-align: start;text-indent: 0px;background-color: rgb(32, 49, 78);"><strong><span lang="EN-US" style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; font-size: 9pt; font-family: Helvetica; color: white;">InsiderLab Fintech Pvt. Ltd.&nbsp;</span><span lang="EN-GB" style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; font-size: 9pt; font-family: Helvetica; color: black;"><br></span><span lang="EN-US" style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #20314E; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; font-size: 9pt; font-family: Helvetica; color: white;"><a data-saferedirecturl="https://www.google.com/url?q=http://www.insiderlab.in&source=gmail&ust=1617822018203000&usg=AFQjCNGQotxCC2F5uWk4Jt7ziG2CTQNfpQ" href="http://www.insiderlab.in/" rel="noreferrer" style="color: white;" target="_blank"><span style="color: white;">www.insiderlab.in</span></a><br>Registered Office : 1603/1 RTO Road South Civil Lines, Jabalpur, Madhya Pradesh, 482001<br>Branch Office : Office A4 Sai Heritage Commercial (LGF) Plot No. 22, Sector 14, Kaushambhi</span>&nbsp;</strong></p></body>
</html>';
                //                $message = "Hi $case->first_name,
                //
                //Good to be in your Inbox again!
                //
                //We hope all your questions were addressed, and you were able to make informed selection decision.
                //
                //If you still feel the need for detailed discussion which would build more trust for you to confirm this selection,
                //
                //reach out to us at support@insiderlab.in or call us on +918810600135 between 10am – 6pm Monday to Friday.
                //
                //
                //
                //We have received your selection of loan product by $user->name on InsiderLab platform. The details of selected product are
                //
                //Lender Name : $case->first_name $case->last_name
                //
                //
                //Loan Amount : $case->load_amount
                //
                //
                //Tenure : $case->disbursed_tenure
                //
                //
                //Interest Rate : $case->disbursed_interest_rate
                //
                //
                //
                //
                //Please provide the below OTP to the $user->name validating your product selection.
                //
                //
                //
                //							$otp
                //
                //
                //** Please note, the product details and availability of financial product is tentative and restricted to the personal information provided by you as of now. The actual product details and availability will be share to you after the CIBIL calculation and evaluation of your application by your selected lender.
                //
                //**Please be assured that you’re all the documented data is safe with us and will be purged after the case completion.
                //
                //
                //
                //Thanks,
                //
                //InsiderLab Fintech Pvt. Ltd.
                //
                //Rgtd Address: 1603/1 RTO Road, South Civil Lines, Jabalpur, MP, 482001.";
                if (!isset($case)) {
                    return response()->json([
                        "error" => 1,
                        "message" => "Case not found",
                        "show_message" => true
                    ]);
                }
                $case->product_otp = $otp;
                $case->save();
                $json["case"] = $case;
            }

            Log::info('OTP ', [$otp]);
             //print_r($mobile);exit;
            $mobSmsRes = $mobileIntraction->sendEmail($message, $mobile, $subjectLine);
            Log::info('mobSmsRes', [$mobSmsRes]);
            if ($mobSmsRes) {
                // $mobileVerification = new MobileVerification();
                // $mobileVerification->mobile_number = $mobile;
                // $mobileVerification->otp = $otp;
                // $mobileVerification->is_verified = 0;
                // $mobileVerification->updated_at = Carbon::now();
                // $mobileVerification->save();
                $mobileVerification = MobileVerification::updateOrCreate(
                    ["mobile_number" => $mobile],
                    [
                        "otp" => $otp,
                        "is_verified" => 0,
                        "updated_at" => Carbon::now()
                    ]
                );
                Log::info('mobileVerification', [$mobileVerification]);
                $json["error"] = 0;
                $json["message"] = "OTP send on mobile to verify.";
                $json["show_message"] = true;
                $json["debug"] = $mobSmsRes;
                return response()->json($json);
            } else {
                Log::info('Error sending OTP please try again.');
                $json["error"] = 1;
                if (isset($json["case"])) {
                    $case = Cases::find($json["case"]->id);
                    if ($request->type == "case") {
                        $case->delete();
                    }
                    $json["case"] = [];
                }
                $json["message"] = "Error sending OTP please try again.";
                $json["show_message"] = true;
                return response()->json($json);
            }
        } catch (Exception $e) {
            Log::error('Exception', [$e]);
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true,
            ]);
        }
    }


    public function verifyOTP(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        $json["error"] = 0;
        $json["message"] = "OTP verified";
        try {
            $inputVerifier = $request->email;
            if (!isset($inputVerifier) || !isset($request->otp)) {
                return response()->json([
                    "error" => 1,
                    "message" => "Mobile number and OTP both are mandatory.",
                    "show_message" => true
                ]);
            } else {
                if (isset($request->type)) {

                    switch ($request->type) {
                        case "case":
                            if (!$user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "User Unauthorized",
                                    "show_message" => true
                                ], 401);
                            }
                            if (!isset($request->case_id)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "Case id is mandatory",
                                    "show_message" => true
                                ]);
                            }
                            $case = Cases::find($request->case_id);
                            if (!isset($case)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "Case not found",
                                    "show_message" => true
                                ]);
                            }
                            if ($case->new_otp != $request->otp) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "OTP did not matched.",
                                    "show_message" => true
                                ]);
                            }
                            if ($case->new_otp == $request->otp) {
                                $case->status = "new";
                                $case->save();
                                return response()->json([
                                    "error" => 0,
                                    "message" => "OTP verified successfully.",
                                    "show_message" => true
                                ]);
                            }
                            break;
                        case "product_selection":
                            if (!$user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "User Unauthorized",
                                    "show_message" => true
                                ], 401);
                            }
                            if (!isset($request->case_id) || !isset($request->product_id)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "Case id and product id is mandatory",
                                    "show_message" => true
                                ]);
                            }
                            $product = Products::find($request->product_id);
                            if (!isset($product)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "Product not found",
                                    "show_message" => true
                                ]);
                            }
                            $case = Cases::find($request->case_id);
                            if (!isset($case)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "Case not found",
                                    "show_message" => true
                                ]);
                            }
                            if ($case->product_otp != $request->otp) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "OTP did not matched.",
                                    "show_message" => true
                                ]);
                            }
                            if ($case->product_otp == $request->otp) {
                                $case->selected_loan = $request->product_id;
                                $case->save();
                                return response()->json([
                                    "error" => 0,
                                    "message" => "OTP verified successfully.",
                                    "show_message" => true
                                ]);
                            }
                            break;
                        case "agent":
                            $mobileVerification = MobileVerification::where([["mobile_number", "=", $inputVerifier], ["otp", "=", $request->otp], ["is_verified", "=", 0]])->first();
                            if (isset($mobileVerification->updated_at) &&  $mobileVerification->updated_at->diffInMinutes(Carbon::now(), true) > 20) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "OTP expired. Please try again",
                                    "show_message" => true
                                ]);
                            } else if (!isset($mobileVerification->updated_at)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "No matching record found",
                                    "show_message" => true
                                ]);
                            } else {
                                $mobileVerification->is_verified = 1;
                                $mobileVerification->updated_at = Carbon::now();
                                $mobileVerification->save();
                                try {
                                    $agent = Agents::where([["email", "=", $request->email]])->first();
                                    if (isset($agent) && isset($agent->id)) {
                                    } else {
                                        $agent = new Agents();
                                        $agent->email = $request->email;
                                        $agent->save();
                                    }
                                } catch (\Exception $e) {
                                    return response()->json([
                                        "error" => 1,
                                        "message" => $e->getMessage(),
                                        "show_message" => true
                                    ]);
                                }
                                return response()->json([
                                    "error" => 0,
                                    "message" => "Mobile number verified successfully.",
                                    "show_message" => false,
                                    "data" => $agent
                                ]);
                            }
                            break;
                        default:
                            $mobileVerification = MobileVerification::where([["mobile_number", "=", $inputVerifier], ["otp", "=", $request->otp], ["is_verified", "=", 0]])->first();
                            if (isset($mobileVerification->updated_at) &&  $mobileVerification->updated_at->diffInMinutes(Carbon::now(), true) > 20) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "OTP expired. Please try again",
                                    "show_message" => true
                                ]);
                            } else if (!isset($mobileVerification->updated_at)) {
                                return response()->json([
                                    "error" => 1,
                                    "message" => "No matching record found",
                                    "show_message" => true
                                ]);
                            } else {
                                $mobileVerification->is_verified = 1;
                                $mobileVerification->updated_at = Carbon::now();
                                $mobileVerification->save();
                                try {
                                    $agent = Agents::where([["email", "=", $request->email]])->first();
                                    if (isset($agent) && isset($agent->id)) {
                                    } else {
                                        $agent = new Agents();
                                        $agent->email = $request->email;
                                        $agent->save();
                                    }
                                } catch (\Exception $e) {
                                    return response()->json([
                                        "error" => 1,
                                        "message" => $e->getMessage(),
                                        "show_message" => true
                                    ]);
                                }
                                return response()->json([
                                    "error" => 0,
                                    "message" => "Mobile number verified successfully.",
                                    "show_message" => false,
                                    "data" => $agent
                                ]);
                            }
                            break;
                    }
                } else {
                    $mobileVerification = MobileVerification::where([["mobile_number", "=", $inputVerifier], ["otp", "=", $request->otp], ["is_verified", "=", 0]])->first();
                    if (isset($mobileVerification->updated_at) &&  $mobileVerification->updated_at->diffInMinutes(Carbon::now(), true) > 20) {
                        return response()->json([
                            "error" => 1,
                            "message" => "OTP expired. Please try again",
                            "show_message" => true
                        ]);
                    } else if (!isset($mobileVerification->updated_at)) {
                        return response()->json([
                            "error" => 1,
                            "message" => "No matching record found",
                            "show_message" => true
                        ]);
                    } else {


                        $mobileVerification->is_verified = 1;
                        $mobileVerification->updated_at = Carbon::now();
                        $mobileVerification->save();
                        try {
                            $agent = Agents::where([["email", "=", $request->email]])->first();
                            if (isset($agent) && isset($agent->id)) {
                            } else {
                                $agent = new Agents();
                                $agent->email = $request->email;
                                $agent->save();
                            }
                        } catch (\Exception $e) {
                            return response()->json([
                                "error" => 1,
                                "message" => $e->getMessage(),
                                "show_message" => true
                            ]);
                        }

                        return response()->json([
                            "error" => 0,
                            "message" => "Mobile number verified successfully.",
                            "show_message" => false,
                            "data" => $agent
                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function questionsList(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        try {
            $questions = Config("questions");
            return response()->json([
                "error" => 0,
                "message" => "Question retrived",
                "data" => [
                    "questions" => $questions
                ],
                "show_message" => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function saveQuestions(Request $request)
    {
        // try {

        //     if (!$user = JWTAuth::parseToken()->authenticate()) {
        //         return response()->json([
        //             "error" => 1,
        //             "message" => "User Not Found.",
        //             "show_message" => true
        //         ], 404);
        //     }
        // } catch (TokenExpiredException $e) {

        //     return response()->json([
        //         "error" => 1,
        //         "message" => "Token Expired.",
        //         "show_message" => true
        //     ], $e->getCode());
        // } catch (TokenInvalidException $e) {

        //     return response()->json([
        //         "error" => 1,
        //         "message" => "Invalid Token.",
        //         "show_message" => true
        //     ], $e->getCode());
        // } catch (JWTException $e) {

        //     return response()->json([
        //         "error" => 1,
        //         "message" => "Token Not Found",
        //         "show_message" => true
        //     ], $e->getCode());
        // }
        try {
            if (!isset($request->questions)) {
                return response()->json([
                    "error" => 0,
                    "message" => "Required parameter questions missing.",
                    "show_message" => true
                ]);
            }

            if (!isset($request->bank_details)) {
                return response()->json([
                    "error" => 0,
                    "message" => "Required parameter Bank Details is missing.",
                    "show_message" => true
                ]);
            }

            if (!isset($request->terms_conditions)) {
                return response()->json([
                    "error" => 0,
                    "message" => "Required parameter Terms And Conditions is missing.",
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

            $questions = new QuestionAnswer();
            $questions->user_id = $request->user_id;
            $questions->question_list = $request->questions;
            $questions->save();

            return response()->json([
                "error" => 0,
                "message" => "Your request has been sent for approval. We'll let you know once it's approved",
                "show_message" => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ], 200);
        }
    }

    public function forgetPasswordSendOTP(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        try {
            $json = [];
            Log::info('All Data', [$request]);
            $mobile = $request->email;
            $type = "agent";
            $mobileIntraction = new MobileIntractions();
            $otp = $mobileIntraction->createOTP($type);
            $message = "{$otp} is the OTP to reset your password with Insider Lab. And is valid for 20 minutes";
            $subjectLine = "OTP for reset password with Insider Labs";
            $agentWithSameMobile = Agents::where([["email", "=", $mobile]])->first();
            if (!isset($agentWithSameMobile)) {
                Log::info("User does not exists in system", [$agentWithSameMobile]);
                return response()->json([
                    "error" => 1,
                    "message" => "User does not exists in system",
                    "show_message" => true
                ]);
            }
            Log::info('OTP ', [$otp]);

            $mobSmsRes = $mobileIntraction->sendEmail($message, $mobile, $subjectLine);
            Log::info('mobSmsRes', [$mobSmsRes]);
            if ($mobSmsRes) {
                $mobileVerification = MobileVerification::updateOrCreate(
                    ["mobile_number" => $mobile],
                    [
                        "otp" => $otp,
                        "is_verified" => 0,
                        "updated_at" => Carbon::now()
                    ]
                );
                Log::info('mobileVerification', [$mobileVerification]);
                $json["error"] = 0;
                $json["message"] = "OTP send on email to verify.";
                $json["show_message"] = true;
                $json["debug"] = $mobSmsRes;
                return response()->json($json);
            } else {
                Log::info('Error sending OTP please try again.');
                $json["error"] = 1;
                $json["message"] = "Error sending OTP please try again.";
                $json["show_message"] = true;
                return response()->json($json);
            }
        } catch (Exception $e) {
            Log::error('Exception', [$e]);
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true,
            ]);
        }
    }

    public function verifyOTPResetPassword(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        $json["error"] = 0;
        $json["message"] = "OTP verified";
        try {
            $inputVerifier = $request->email;
            if (!isset($inputVerifier) || !isset($request->otp)) {
                return response()->json([
                    "error" => 1,
                    "message" => "Mobile number and OTP both are mandatory.",
                    "show_message" => true
                ]);
            } elseif (!isset($request->new_password) || !isset($request->confirm_password)) {
                return response()->json([
                    "error" => 1,
                    "message" => "New password and confirm password both are mandatory.",
                    "show_message" => true
                ]);
            } elseif ($request->new_password != $request->confirm_password) {
                return response()->json([
                    "error" => 1,
                    "message" => "New password and confirm password does not match",
                    "show_message" => true
                ]);
            } else {
                $mobileVerification = MobileVerification::where([["mobile_number", "=", $inputVerifier], ["otp", "=", $request->otp], ["is_verified", "=", 0]])->first();
                if (isset($mobileVerification->updated_at) && $mobileVerification->updated_at->diffInMinutes(Carbon::now(), true) > 20) {
                    return response()->json([
                        "error" => 1,
                        "message" => "OTP expired. Please try again",
                        "show_message" => true
                    ]);
                } else if (!isset($mobileVerification->updated_at)) {
                    return response()->json([
                        "error" => 1,
                        "message" => "No matching record found",
                        "show_message" => true
                    ]);
                } else {
                    $mobileVerification->is_verified = 1;
                    $mobileVerification->updated_at = Carbon::now();
                    $mobileVerification->save();
                    try {
                        $agent = Agents::where([["email", "=", $request->email]])->first();
                        if (isset($agent) && isset($agent->id)) {
                            $agent->password = bcrypt($request->new_password);
                            $agent->save();
                        } else {
                            $agent_new = new Agents();
                            $agent_new->email = $request->email;
                            $agent_new->password = bcrypt($request->new_password);
                            $agent_new->save();
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            "error" => 1,
                            "message" => $e->getMessage(),
                            "show_message" => true
                        ]);
                    }

                    return response()->json([
                        "error" => 0,
                        "message" => "Password has been changed successfully.",
                        "show_message" => false,
                        "data" => $agent
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        $json["error"] = 0;
        $json["message"] = "OTP verified";
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Not Found.",
                    "show_message" => true
                ], 404);
            }
            if (!isset($request->new_password) || !isset($request->confirm_password)) {
                return response()->json([
                    "error" => 1,
                    "message" => "New password and confirm password both are mandatory.",
                    "show_message" => true
                ]);
            } elseif ($request->new_password != $request->confirm_password) {
                return response()->json([
                    "error" => 1,
                    "message" => "New password and confirm password does not match",
                    "show_message" => true
                ]);
            } else {
                try {
                    $agent = Agents::where([["id", "=", $user->id]])->first();
                    $agent->password = bcrypt($request->new_password);
                    $agent->save();
                } catch (\Exception $e) {
                    return response()->json([
                        "error" => 1,
                        "message" => $e->getMessage(),
                        "show_message" => true
                    ]);
                }

                return response()->json([
                    "error" => 0,
                    "message" => "Password has been changed successfully.",
                    "show_message" => false,
                    "data" => $agent
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function agentDetails(Request $request)
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
                    "message" => "User Not Found.",
                    "show_message" => true
                ], 404);
            }

            $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
            $files = Storage::disk('s3')->files("agents/$user->id/");
            $files = array_reverse($files);
            $docs = [];
            if (!empty($files)) {
                for ($i = 0; $i < 5; $i++) {
                    $i_n = $i + 1;
                    if (isset($url) && isset($files[$i])) {
                        $docs[] = "$url$files[$i]";
                    }
                }
            }
            $user->docs = $docs;
        } catch (TokenExpiredException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Expired.",
                "show_message" => true
            ], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Invalid Token.",
                "show_message" => true
            ], $e->getCode());
        } catch (JWTException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Not Found",
                "show_message" => true
            ], $e->getCode());
        }

        return response()->json([
            "error" => 0,
            "message" => "Agent Details",
            "data" =>  $user,
            "show_message" => false
        ]);
    }

    public function agentUpdate(Request $request)
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
                    "message" => "User Not Found.",
                    "show_message" => true
                ], 404);
            }

            try {
                $agent = Agents::where([["id", "=", $user->id]])->first();
                $agent->name = $request->name == '' ? $agent->name : $request->name;
                $agent->mobile = $request->mobile == '' ? $agent->mobile : $request->mobile;
                $agent->location = $request->location == '' ? $agent->location : $request->location;
                $agent->save();
            } catch (\Exception $e) {
                return response()->json([
                    "error" => 1,
                    "message" => $e->getMessage(),
                    "show_message" => true
                ]);
            }

            return response()->json([
                "error" => 0,
                "message" => "Agent details updated successfully.",
                "show_message" => false,
                "data" => $agent
            ]);
        } catch (TokenExpiredException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Expired.",
                "show_message" => true
            ], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Invalid Token.",
                "show_message" => true
            ], $e->getCode());
        } catch (JWTException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Not Found",
                "show_message" => true
            ], $e->getCode());
        }

        return response()->json([
            "error" => 0,
            "message" => "Agent Details",
            "data" =>  $user,
            "show_message" => false
        ]);
    }
	public function updateAgent(Request $request)
    {    
		$id = $request->id;
		
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
                    "message" => "User Not Found.",
                    "show_message" => true
                ], 404);
            }
			//print_r($request->all());exit;
            try {
                $agent = Agents::where([["id", "=", $user->id]])->first();
                $agent->name = $request->name == '' ? $agent->name : $request->name;
                $agent->mobile = $request->mobile == '' ? $agent->mobile : $request->mobile;
                $agent->location = $request->location == '' ? $agent->location : $request->location;
                $agent->email = $request->email == '' ? $agent->email : $request->email;
                $agent->aadhar_card = $request->aadhar_card == '' ? $agent->aadhar_card : $request->aadhar_card;
                $agent->account_holder_name = $request->account_holder_name == '' ? $agent->account_holder_name : $request->account_holder_name;
                $agent->account_number = $request->account_number == '' ? $agent->account_number : $request->account_number;
                $agent->ifsc_code = $request->ifsc_code == '' ? $agent->ifsc_code : $request->ifsc_code;
                $agent->dob = $request->dob == '' ? $agent->dob : $request->dob;
                $agent->gender = $request->gender == '' ? $agent->gender : $request->gender;
                $agent->bank_name = $request->bank_name == '' ? $agent->bank_name : $request->bank_name;
                $agent->current_profession = $request->current_profession == '' ? $agent->current_profession : $request->current_profession;
                $agent->employment_type = $request->employment_type == '' ? $agent->employment_type : $request->employment_type;
                $agent->work_experience = $request->work_experience == '' ? $agent->work_experience : $request->work_experience;
                $agent->employer_name = $request->employer_name == '' ? $agent->employer_name : $request->employer_name;
                $agent->financial_industry = $request->financial_industry == '' ? $agent->financial_industry : $request->financial_industry;
                $agent->hold_gov_office = $request->hold_gov_office == '' ? $agent->hold_gov_office : $request->hold_gov_office;
                $agent->save();
            } catch (\Exception $e) {
                return response()->json([
                    "error" => 1,
                    "message" => $e->getMessage(),
                    "show_message" => true
                ]);
            }

            return response()->json([
                "error" => 0,
                "message" => "Agent details updated successfully.",
                "show_message" => false,
                "data" => $agent
            ]);
        } catch (TokenExpiredException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Expired.",
                "show_message" => true
            ], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Invalid Token.",
                "show_message" => true
            ], $e->getCode());
        } catch (JWTException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Not Found",
                "show_message" => true
            ], $e->getCode());
        }

        return response()->json([
            "error" => 0,
            "message" => "Agent Details",
            "data" =>  $user,
            "show_message" => false
        ]);
    }

    public function getDetailsNew(Request $request)
    {
       
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        try {

            // if (!$user = JWTAuth::parseToken()->authenticate()) {
            //     return response()->json([
            //         "error" => 1,
            //         "message" => "User Not Found.",
            //         "show_message" => true
            //     ], 404);
            // }
            $id = $request->id;
            $user = Agents::where([["id", "=", $id]])->first();
            //print_r($user );exit;
            $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
            $files = Storage::disk('s3')->files("agents/$user->id/");
            $files = array_reverse($files);
            $docs = [];
            if (!empty($files)) {
                for ($i = 0; $i < 5; $i++) {
                    $i_n = $i + 1;
                    if (isset($url) && isset($files[$i])) {
                        $docs[] = "$url$files[$i]";
                    }
                }
            }
            $user->docs = $docs;
        } catch (TokenExpiredException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Expired.",
                "show_message" => true
            ], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Invalid Token.",
                "show_message" => true
            ], $e->getCode());
        } catch (JWTException $e) {

            return response()->json([
                "error" => 1,
                "message" => "Token Not Found",
                "show_message" => true
            ], $e->getCode());
        }

        return response()->json([
            "error" => 0,
            "message" => "Agent Details",
            "data" =>  $user,
            "show_message" => false
        ]);
    }
}
