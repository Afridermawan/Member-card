<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;
/**
*
*/
class UserPinController extends Controller
{
    /**
    * Sample handler
    */
    public function getPin($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'pin/list',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 2,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'pin/list?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 2
                    ]
                ]);

            }else {
                $result = $this->client->request('GET', 'pin/list',
                    [
                        'headers' => [
                            'limit' => 2,
                    ]
                ]);
            }

		} catch (GuzzleException $e) {
			$result = $e->getResponse();
		}

        $data = json_decode($result->getBody()->getContents());

		return $this->view->render($response, 'backend/admin/user/pin', [
            'data'      =>  $data->data,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/pin/",
            'title'     =>  "Pengguna"
        ]);
    }

    public function getPinId($request, $response, $args)
    {
        $_SESSION['login'] = $session;
        try {
            $result = $this->client->request('GET', 'pin/'.$session->user_id.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        $_SESSION['pin'] = $data->data;

        return $this->view->render($response, 'backend/user/user/detail', [
            'data'	=> $data->data
        ]);
    }

    public function delete($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'pin/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.pin'));
    }

    public function restore($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'pin/'.$args['id'].'/restore');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        return $this->view->render($response, 'article/detail.twig', [
            'data'	=> $data['data']
        ]);
    }

    public function getAddPin($request, $response, $args)
    {
        $session = $_SESSION['login'];

        return $this->view->render($response, 'backend/user/user/pin', [
            'session'   =>  $session,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/web/pin/",
            'title'     =>  "Add PIN"
        ]);
    }

    public function addPin($request, $response)
    {
        $session = $_SESSION['login'] ;

        try {
            $result = $this->client->request('POST', 'pin/add',[
                'form_params' => [
                    'user_id'          =>  $session->id,
                    'pin'              =>  $request->getParam('pin'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if ($data->error == false) {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('add.pin'));
        }
    }

    public function getEditPin($request, $response, $args)
    {
        $session = $_SESSION['login'] ;

        try {
            $result = $this->client->request('GET', 'pin/'.$session->user_id.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'backend/user/user/edit-pin', [
            'data'      =>  $data->data,
            'session'   =>  $session,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/web/pin/",
            'title'     =>  "Edit PIN"
        ]);
    }
    public function putPin($request, $response)
    {
        $session = $_SESSION['login'];

        try {
            $result = $this->client->request('POST', 'pin/edit',[
                'form_params' => [
                    'user_id'          =>  $session->user_id,
                    'pin'              =>  $request->getParam('pin'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if ($data->error == false) {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('edit.pin'));
        }
    }

    public function checkPassword($request, $response)
    {
        $session = $_SESSION['login'];

        try {
            $result = $this->client->request('POST', 'pin/check/password',[
                'form_params' => [
                    'user_id'          =>  $session->user_id,
                    'password'         =>  $request->getParam('password'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if ($data->error == false) {
            if (isset($_SESSION['pin'])) {
                $this->flash->addMessage('success', $data->message);
                return $response->withRedirect($this->router->pathFor('edit.pin'));
            }else {
                $this->flash->addMessage('success', $data->message);
                return $response->withRedirect($this->router->pathFor('add.pin'));
            }
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        }
    }
}
