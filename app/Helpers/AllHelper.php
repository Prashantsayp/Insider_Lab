<?php

namespace App\Helpers;

use Exception;
use App\Mail\Opt;
use App\Helpers\TextLocal;
use App\Models\MobileVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AllHelper
{

    public function calculateEMI ($principal, $yearlyRateOfInterest, $monthlyTenure)
    {
        //  [P x R x (1+R)^N]/[(1+R)^N-1]
        $monthlyRateOfInterest = ($yearlyRateOfInterest / 12)/100;
        return ($principal * $monthlyRateOfInterest * (pow(1 + $monthlyRateOfInterest, $monthlyTenure) ) ) / (pow((1 + $monthlyRateOfInterest), $monthlyTenure-1));
    }


}
