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


    public function _buildQuery($params)
    {
        $params['key'] = $this->apiKey;
        $queryParams   = http_build_query($params);
        $fullQueryUrl  = $this->reqUrl . $queryParams;

        return $fullQueryUrl;
    }

}


?>
