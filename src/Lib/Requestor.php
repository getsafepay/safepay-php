<?php

namespace Safepay\Lib;

use Safepay\Base;


class Requestor extends Base
{


    public function __construct()
    {
    }
    /**
     * Get the response from an API request.
     * @param  string $endpoint
     * @param  array  $params
     * @param  string $method
     * @return array
     */
    public static function send_request($environment = "sandbox", $endpoint = "", $params = array(), $method = 'GET')
    {

        $baseURL = $environment === self::SANDBOX ? self::$sandbox_api_url : self::$production_api_url;
        $url = $baseURL . $endpoint;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $headers = [
            'Content-Type: application/json'
        ];


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($environment === self::SANDBOX) {

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }


        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);


        curl_close($ch);

        $response = json_decode($server_output, true);

        if ($response['status']['message'] == 'success') {
            return array(true, $response);
        } else {
            return array(false, $response['status']['message']);
        }
    }
}
