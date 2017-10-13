<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

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
        $messages = $this->flash->getMessages();
		return $this->view->render($response, '/backend/admin/home', [
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Home",
            'messages'  =>  $messages
        ]);
    }

    public function home($request, $response)
    {
        $session = $_SESSION['login'];

        $messages = $this->flash->getMessages();
        return $this->view->render($response, '/backend/user/home', [
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Home",
            'messages'  =>  $messages,
            'session'   =>  $session,
        ]);
    }

    public function notFound($request, $response)
    {
        $messages = $this->flash->getMessages();
        return $this->view->render($response, '/errors/404', [
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Halaman tidak ditemukan",
            'messages'  =>  $messages
        ]);
    }
}
