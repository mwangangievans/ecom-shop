<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class MpesaController extends Controller
{
    /** Lipa na M-PESA password **/
    public function getPassword()
    {
        $timestamp = Carbon::rawParse('now')->format('YmdHms'); //Helps us get current date and time
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";  //Pass key from the Daraja app. See https://developer.safaricom.co.ke/test_credentials
        $BusinessShortCode = 174379; //This is the test business shortcode we are going to use. See https://developer.safaricom.co.ke/test_credentials
        $password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        return $password;
    }
    /** Lipa na M-PESA STK Push method **/
    public function stkPushRequest(Request $request)
    {
        $phone = $request->phone_number;  //We use request to get the phone number that the user inputs for the form.
        $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));
        $curl_post_data = [
            //Use valid values for the parameters below
            'BusinessShortCode' => 174379,
            'Password' => $this->getPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'PartyA' => 254798288410, 
            'PartyB' => 174379,
            'PhoneNumber' => 254798288410,
            'CallBackURL' => 'https://mfc.ke/confirm-request.php',
            'AccountReference' => "Mediaforce Communications",
            'TransactionDesc' => "Testing stk push on sandbox"
        ];
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return $curl_response;
    }

    public function generateAccessToken()
    {
        $consumer_key= "V72Uf93McGiw4TwOlIeEavJQ3PTUef4e";
        $consumer_secret= "91hIt8Xi3IAEbcJQ";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }
}