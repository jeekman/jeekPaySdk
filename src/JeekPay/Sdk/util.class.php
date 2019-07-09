<?php

namespace JeekPay\Sdk;

use JeekPay\Error;

class util
{
    /**
     *  Convert parameter array to url parameter
     * @param $params
     * @return string
     * @throws Error\Api
     */
    public function toUrlParams($params)
    {
        self::validateParams($params);

        $result = "";

        ksort($params);

        foreach ($params as $key => $value){
            if ($key != "sign" && $key != "signType" && strlen($value) > 0){
                $result .= $key . "=" .$value . "&";
            }
        }

        $result = trim($result,"&");

        return $result;
    }

    /**
     *  Generate signature
     * @param $str
     * @return string
     * @throws Error\Api
     */
    public function makeSign($str)
    {
        if ($str && !is_string($str)){
            $message = "Signature parameter non-string";

            throw new Error\Api($message);
        }

        $result = md5($str);

        return $result;
    }

    /**
     *  Curl request
     * @param $params
     * @return mixed
     * @throws Error\Api
     */
    public function postCurl($params)
    {
        if (empty($params)){
            $message = "The parameter is empty";

            throw new Error\Api($message);
        }

        $url = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output,true);
    }

    /**
     * Verify array
     * @param $params
     * @throws Error\Api
     */
    private static function validateParams($params)
    {
        if ($params && !is_array($params)){
            $message = "You must pass an array as the first argument to JeekPay API";

            throw new Error\Api($message);
        }
    }
}