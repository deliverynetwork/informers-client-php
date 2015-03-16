<?php
/**
 * @package Informers
 * @version 1.0.7
 */

/*
Plugin Name: Informers
Description: Displays informers .
Author: DeliveryNetwork
Version: 1.0
Author URI: http://fleetly.net
*/

include_once "src/Client.php";
include_once "src/CustomCache.php";
include_once "src/ClientException.php";

function informers_client() {

    $siteId = 'YOUR_SITE_ID'; // Идентификатор сайта
    $apiKey = 'YOUR_SITE_API_KEY'; // Ключ сайта
    $apiUrl = 'API_URL'; //  API url

    try{

        $client = new \informers\client\Client(
            array(
                "site_id" => $siteId,
                "api_key" => $apiKey,
                "api_url" => $apiUrl,
                "api_max_execution_time" => 0.4,
                "api_max_connection_time" => 0.5,
                'cache'   => new \informers\client\CustomCache(
                    function($key){
                        $result = wp_cache_get($key);
                        return $result;
                    },

                    function($key, $value, $period){
                        return wp_cache_set($key, $value, '', $period);
                    }, 3600, '')
            )
        );
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        echo $client->render($url);
    } catch (\informers\client\ClientException $e) {}

}
