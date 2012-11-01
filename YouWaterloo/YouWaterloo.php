<?php


class YouWaterloo
{

    const USER_AGENT  = 'uWaterloo-PHP';
    const REQ_LIMIT   = 5000;
    const API_VERSION = 'v1';
    const API_URL     = 'http://api.uwaterloo.ca/public/';

    public  $output;
    public  $reqUrl;
    private $apiKey;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->output = 'json';
        $this->reqUrl = self::API_URL . self::API_VERSION.'/?';
    }


    public function getMeta($response)
    {
        $json = self::parseJSON($response);
        $meta = $json->response->meta;
        $resp = self::objectToArray($meta);

        return $resp;
    }


    public function getData($response)
    {
        $json = self::parseJSON($response);
        $data = $json->response->data;
        $resp = self::objectToArray($data);

        return $resp;
    }


    public function buildQuery($params)
    {
        $params['key'] = $this->apiKey;
        $queryParams   = http_build_query($params);
        $fullQueryUrl  = $this->reqUrl . $queryParams;

        return $fullQueryUrl;
    }


    public function makeRequest($url)
    {
        if( in_array('curl', get_loaded_extensions()) && function_exists('curl_init') )
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);

            $data = curl_exec($ch);
            curl_close($ch);

            return $data;
        }
        else
        {
            $data = file_get_contents($url);
            return $data;
        }
    }


    public static function parseJSON($json)
    {
        return json_decode($json);
    }


    public static function objectToArray($object)
    {
        if( is_object($object) )
        {
            $object = get_object_vars($object);
        }

        foreach($object as $key => $value)
        {
            if( is_array($value) || is_object($value) )
            {
                $value = self::objectToArray($value);
            }

            $result[$key] = $value;
        }

        return $result;
    }


}


?>
