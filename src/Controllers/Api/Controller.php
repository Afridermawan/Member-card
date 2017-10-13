<?php

namespace App\Controllers\Api;

/**
* 
*/
abstract class Controller
{
    private $container;

    /**
    * All of the registered container
    */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
    * Dynamically access container
    */
    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
       public function responseWithJson(array $data)
    {
        return $this->response->withHeader('Content-type', 'application/json')
        ->withJson($data, $data['code']);
    }

    public function responseDetail($code, $error, $message, array $data = null)
    {
        if (empty($data['pagination'])) {
            $data['pagination'] = null;
        }
        if (empty($data['data'])) {
            $data['data'] = null;
        }
        if (empty($data['key'])) {
            $data['key'] = null;
        }

        $response = [
            'code'      => $code,
            'error'     => $error,
            'message'   => $message,
            'data'      => $data['data'],
            'pagination'=> $data['pagination'],
            'key'       => $data['key']
        ];

        if ($data['pagination'] == null) {
            unset($response['pagination']);
        }

        if ($data['key'] == null) {
            unset($response['key']);
        }

        return $this->responseWithJson($response, $code);
    }
}