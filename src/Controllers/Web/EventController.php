<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use App\Models\Event;
/**
*
*/
class EventController extends Controller
{
    /**
    * Sample handler
    */
    public function getEvent($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'event/list',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'event/list?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10
                    ]
                ]);
            } else {
                $result = $this->client->request('GET', 'event/list',
                    [
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            }

		} catch (GuzzleException $e) {
			$result = $e->getResponse();
		}

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();
        $session = $_SESSION['login'];
        if ($session->role_id == 1) {
    		return $this->view->render($response, 'backend/admin/event/index', [
                'data'      => $data->data,
                'base_url'  =>  "http://localhost:8000",
                'link'      =>  "http://localhost:8000/admin/event/",
                'title'     =>  "Event",
                'messages'  =>  $messages
            ]);
        } else {
            return $this->view->render($response, 'backend/user/event/index', [
                'data'      => $data->data,
                'base_url'  =>  "http://localhost:8000",
                'link'      =>  "http://localhost:8000/web/event/",
                'title'     =>  "Event",
                'messages'  =>  $messages
            ]);
        }
    }

    public function getEventDetailId($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'event/'.$args['id'].'/find'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        return $this->view->render($response, 'article/detail.twig', [
            'data'	=> $data['data']
        ]);
    }

    public function getEventDetailSlug($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'event/'.$args['slug'].'/detail'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        return $this->view->render($response, 'article/detail.twig', [
            'data'	=> $data['data']
        ]);
    }

    public function softdelete($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'event/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.event'));
    }

    public function listItems($request, $response, $args)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'event/list/items',
                    [
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'event/list?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10
                    ]
                ]);
            } else {
                $result = $this->client->request('GET', 'event/list/items',
                    [
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            }

		} catch (GuzzleException $e) {
			$result = $e->getResponse();
		}

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();
        return $this->view->render($response, 'backend/admin/event/penjualan', [
            'data'      => $data->data,
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/event/list/items",
            'title'     =>  "Event",
            'messages'  =>  $messages
        ]);
    }

    public function restore($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'event/'.$args['id'].'/restore');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.event'));   
    }

    public function removeBuyerEvent($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'event/'.$args['id'].'/remove/event/item');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('remove.buyer.event'));
    }

    public function getAddEvent($request, $response)
    {
        return $this->view->render($response, 'backend/admin/event/add', [
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/event/list/items",
            'title'     =>  "Event"
        ]);
    }

    public function addEvent($request, $response)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'event/add',[
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                    [
                        'name'      =>  'name',        
                        'contents'  =>  $request->getParam('name'),                        
                    ],
                    [
                        'name'      =>  'biaya_pendaftaran',        
                        'contents'  =>  $request->getParam('biaya_pendaftaran'),                        
                    ],
                    [
                        'name'      =>  'description',        
                        'contents'  =>  $request->getParam('description'),                        
                    ],
                    [
                        'name'      =>  'start_date',        
                        'contents'  =>  $request->getParam('start_date'),                        
                    ],                                        
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('add.event'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.event'));
        }
    }

    public function getEditEvent($request, $response, $args)
    {
        $event = new Event;
        $data = $event->where('id', $args['id'])->first();
        return $this->view->render($response, 'backend/admin/event/edit', [
            'data'      =>  $data,
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Event"
        ]);
    }

    public function putEvent($request, $response, $args)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'event/'.$args['id'].'/edit',[
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                    [
                        'name'      =>  'name',        
                        'contents'  =>  $request->getParam('name'),                        
                    ],
                    [
                        'name'      =>  'biaya_pendaftaran',        
                        'contents'  =>  $request->getParam('biaya_pendaftaran'),                        
                    ],
                    [
                        'name'      =>  'description',        
                        'contents'  =>  $request->getParam('description'),                        
                    ],
                    [
                        'name'      =>  'start_date',        
                        'contents'  =>  $request->getParam('start_date'),                        
                    ],                                        
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('edit.event'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.event'));
        }
    }

    public function getBuy($request, $response)
    {
        return $this->view->render($response, 'backend/admin/event/addBuy', [
            'base_url'  =>  "http://localhost:8000",
            'link'      =>  "http://localhost:8000/admin/event/list/items",
            'title'     =>  "Event"
        ]);
    }

    public function buy($request, $response, $args) 
    {
        $query = $request->getQueryParams();
        try {
            $result = $this->client->request('POST', 'event/'.$args['id'].'/buy',[
                'form_params' => [
                    'user_id'              =>  $session->user_id,
                    'event_id'             =>  $args['id'],
                    'kuantitas'            =>  $request->getParam('kuantitas'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        $_SESSION['event'] = $data->data;

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('daftar.event'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('detail.daftar.event', [
                'id' => $args['id']]));
        }
    }

    public function getBuyEvent($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'event/'.$args['id'].'/find'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/event/pendaftaran', [
            'data'      =>  $data->data,
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Daftar Event",
            'messages'  =>  $messages
        ]);
    }

    public function findItems($request, $response, $args)
    {
        $event = $_SESSION['event'];
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/event/detail-pendaftaran', [
            'event'      =>  $event,
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Detail Pendaftaran",
            'messages'  =>  $messages
        ]);
    }

    public function bayar($request, $response, $args)
    {
        $messages = $this->flash->getMessages();
        
        return $this->view->render($response, 'backend/user/event/bayar', [
            'produk'      => $produk,
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Bayar",
            'messages'  =>  $messages
        ]);
    }
}
