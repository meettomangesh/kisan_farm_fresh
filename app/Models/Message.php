<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ApiModel;
use PDO; 

class Message extends ApiModel 
{
    /**
     * Send Message to user mobile
     * return success response or error response in json
     */
    public function sendMessage($to, $textMessage, $merchantId, $channelType, $params = [])
    {
        try
        {
            // $smsGateway = [];
            // $smsGateway = $this->getMerchantSmsCredentials($merchantId, $channelType);
            // $smsGateWayUrl = getenv('SMS_GATEWAY_API_BASE_URL');
            // $username = getenv('SMS_GATEWAY_USERNAME');
            // $password = getenv('SMS_GATEWAY_PASSWORD');
            // $smsGateWayUrl = $smsGateWayUrl . '?feedid=' . $smsGateway['feed_id'];
            // $smsGateWayUrl = $smsGateWayUrl . '&username=' . $username;
            // $smsGateWayUrl = $smsGateWayUrl . '&password=' . $password;
            // $smsGateWayUrl = $smsGateWayUrl . '&to=' . $to;
            // $smsGateWayUrl = $smsGateWayUrl . '&text=' . str_replace(' ', '+', $textMessage);
            // $smsGateWayUrl = $smsGateWayUrl . '&time=';
            // $smsGateWayUrl = $smsGateWayUrl . '&senderid=' . $smsGateway['sender_id'];
            // $objURL = curl_init($smsGateWayUrl);
            // curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1);
            // $retVal = trim(curl_exec($objURL));
            // curl_close($objURL);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

        /**
     * Send OTP to user mobile
     * return success response or error response in json
     */
    public function sendOtp($to, $textMessage, $params = [])
    {
        try
        {

            // $smsGateWayUrl = getenv('SMS_GATEWAY_API_BASE_URL');
            // $username = getenv('SMS_GATEWAY_USERNAME');
            // $password = getenv('SMS_GATEWAY_PASSWORD');
            // //$smsGateWayUrl = $smsGateWayUrl.'?feedid='.$smsGateway['feed_id'];
            // $smsGateWayUrl = $smsGateWayUrl . '?username=' . $username;
            // $smsGateWayUrl = $smsGateWayUrl . '&password=' . $password;
            // $smsGateWayUrl = $smsGateWayUrl . '&to=' . $to;
            // $smsGateWayUrl = $smsGateWayUrl . '&from=' . getenv('SENDER_ID');
            // $smsGateWayUrl = $smsGateWayUrl . '&text=' . urlencode($textMessage);
            // $smsGateWayUrl = $smsGateWayUrl . '&dlr-mask=19';
            // $smsGateWayUrl = $smsGateWayUrl . '&dlr-url';

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => $smsGateWayUrl,           
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "GET",
            // ));

            // $response = curl_exec($curl);
            // curl_close($curl);
            return 1;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
