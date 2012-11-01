<?php


class YouWaterloo
{

    const USER_AGENT  = 'uWaterloo-PHP';
    const REQ_LIMIT   = 5000;
    const API_VERSION = 'v1';
    const API_URL     = 'http://api.uwaterloo.ca/pubic/';

    public  $output;
    public  $reqUrl;
    private $apiKey;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->output = 'json';
        $this->reqUrl = self::API_URL.self::API_VERSION.'/';
    }

}


?>
