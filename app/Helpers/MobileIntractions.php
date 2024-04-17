<?php
namespace App\Helpers;

use Exception;
use App\Mail\Opt;
use App\Models\Cases;
use App\Helpers\TextLocal;
use App\Models\MobileVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MobileIntractions {

    public function __construct()
    {

    }

    public function sendSMS($message, $mobile)
    {
        try {
            $textLocal = new TextLocal();
            $res = $textLocal->sendText($mobile, $message);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function sendEmail ($message, $email, $subject) {
        try {
            $name = 'Cloudways';
            Log::info('Message', [$message]);
            //print_r($email);exit;

            Mail::to($email)->send(new Opt($message, $subject));
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            //print_r($e->getMessage());
            //exit;
            return false;
        }


    }



    public function createOTP($type = "agent")
    {
        $otp = rand(100000, 999999);
        if ($type == "agent") {
            $otpTable = MobileVerification::where([["otp", "=", $otp]])->get();
            if (count($otpTable)) {
                $otp = $this->createOTP();
            }
        } else if ($type == "case") {
            $otpTable = Cases::where([["new_otp", "=", $otp]])->get();
            if (count($otpTable)) {
                $otp = $this->createOTP($type);
            }
        } else if ($type == "product_selection") {
            $otpTable = Cases::where([["product_otp", "=", $otp]])->get();
            if (count($otpTable)) {
                $otp = $this->createOTP($type);
            }
        }
        return $otp;
    }
}
