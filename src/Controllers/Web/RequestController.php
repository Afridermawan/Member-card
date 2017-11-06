<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

/**
 *
 */
class RequestController extends Controller
{
    public function index($request, $response)
    {
        try {
            $result = $this->client->request('GET', 'request/list');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/admin/request/index', [
            'data'      =>  $data->data,
            'messages'  =>  $messages,
            'title'     =>  'Request',
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/request/",
        ]);
    }

    public function notif($request, $response)
    {
        try {
            $result = $this->client->request('GET', 'request/list');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $count  = count($data->data);

        return $this->view->render($response, 'templates/partials/top-nav', [
            'notif'     =>  $data->data,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/request/",
            'count'     =>  $count
        ]);
    }

    public function delete($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'request/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        $message = $this->flash->getMessages();

        if ($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('list.request'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.request'));
        }
    }

    public function sendRequest($request, $response)
    {
        $session = $_SESSION['login'];
        try {
            $result = $this->client->request('POST', 'request/send', [
                'form_params' => [
                    'user_id' => $session->user_id
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $url = $_SERVER['HTTP_REFERER'];
        if(!$url) $url = "/";
        if ($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($url);
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($url);
        }
    }

    public function approveRequest($request, $response, $args)
    {
        try {
            $result = $this->client->request('POST', 'request/'.$args['id'].'/approve', [
                'form_params' => [
                    'id' => $args['id']
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if ($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('list.request'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.request'));
        }
    }
}
