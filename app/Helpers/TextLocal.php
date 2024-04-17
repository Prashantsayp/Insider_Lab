<?php
namespace App\Helpers;

use App\Models\MobileVerification;
use Exception;

class TextLocal {
    private $apiKey = "Yh3gOcilYyU-0VYHRaF3TdGJpCQ4aBky5IuSpkSo7b";

    public function __construct()
    {

    }

    public function sendText ($number, $message)
    {
        try {
            $apiKey = urlencode($this->apiKey);

            // Message details
            $numbers = array("91" . $number);
            $sender = urlencode('TXTLCL');
            $message = rawurlencode($message);

            $numbers = implode(',', $numbers);

            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Process your response here
            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
