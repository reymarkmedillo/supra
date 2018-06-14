<?php
namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Exception;
use App\Exception\AjaxException;
use App\ApiResponse;

class ApiModel {
    static function call($method, $url, $params=array(), $ajax=false) {
        try {
            $client = new Client();

            $params['client_secret'] = env('API_SECRET');
            $params['client_name']   = env('API_CLIENT_NAME');

            if(strtoupper($method) == 'GET') {
                $count = 0;
                $lastItem = count($params) - 1;
                foreach ($params as $key => $param) {
                    if($count == 0) $url .= '?';
                    $url .= $key.'='.$param;
                    if($count != $lastItem) $url .= '&';
                    $count++;
                }
            }

            $res = $client->request($method, $url, [
                'form_params' => $params,
                'headers' => []
            ]);

            return new ApiResponse($res);
        } catch (RequestException $e) {
            if($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                if(!isset(json_decode($e->getResponse()->getBody())->message)) {
                    $message = "";
                } else {
                    $message = json_decode($e->getResponse()->getBody())->message;
                }
                if($statusCode == 412 || $statusCode == 422) {
                    return new ApiResponse($e->getResponse());
                } else {
                    return new ApiResponse($e->getResponse());
                }
            }

        }
    }

    static function callByAuth($method, $url, $params=array(), $ajax=false) {
        try {
            $client = new Client();

            $params['client_secret'] = env('API_SECRET');
            $params['client_name']   = env('API_CLIENT_NAME');

            if($method == 'GET') {
                $count = 0;
                $lastItem = count($params) - 1;
                foreach ($params as $key => $param) {
                    if($count==0) $url .= '?';
                    $url .= $key .'='. $param;
                    if($count != $lastItem) $url .= '&';
                    $count++;
                }
            }

            $res = $client->request($method, $url, [
                'form_params' => $params,
                'headers' => [
                    'Authorization' => 'Bearer '. \Session::get('token')['access_token']
                ],
            ]);

            return new ApiResponse($res);

        } catch (RequestException $e) {
            if($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                if(!isset(json_decode($e->getResponse()->getBody())->message)) {
                    $message = "";
                } else {
                    $message = json_decode($e->getResponse()->getBody())->message;
                }

                if($statusCode == 412 || $statusCode == 422) {
                    return new ApiResponse($e->getResponse());
                } else {
                    return new ApiResponse($e->getResponse());
                }
            }
        }
    }

}

?>