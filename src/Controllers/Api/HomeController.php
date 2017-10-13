<?php

namespace App\Controllers\Api;

/**
*
*/
class HomeController extends Controller
{
    /**
    * Sample handler
    */
    public function index($request, $response)
    {
        return $this->view->render($response, 'home');
    }
}
