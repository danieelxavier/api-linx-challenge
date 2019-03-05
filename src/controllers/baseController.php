<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 3/4/19
 * Time: 2:19 PM
 */

namespace Api\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\RequestException;
use Api\Utils\Constants;
use Slim\Http\Response;


class BaseController {

    protected $container;
    public function __construct(\Slim\Container $container){
        $this->container = $container;
    }

    //response to localhost/
    public function index($request, $response, $args) {
        return $response->withStatus(Constants::SUCCESS_STATUS)->write('Seja bem-vindo!');
    }


    //function to abstract requests in controllers
    public static function makeRequest(Response $response, $method, $url, $params = []){

        try {
            $client = new Client();
            return $client->request($method, $url, $params);

        } catch (RequestException $e) {

            $error =  array('message'=> $e->getMessage(), 'error'=>true, 'status'=> Constants::INTERNAL_ERROR_STATUS);

            if ($e->getResponse() != null) {
                $error['status'] =$e->getResponse()->getStatusCode();
                $error['response'] =$e->getResponse()->getBody();
            }

            $res = $response->withStatus($error['status'])
            ->withHeader('content-type', 'application/json')
            ->write(json_encode($error));

            return $res;
        }
    }

}