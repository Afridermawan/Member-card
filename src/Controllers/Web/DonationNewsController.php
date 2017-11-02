<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

/**
*
*/
class DonationNewsController extends Controller
{
    /**
    * Sample handler
    */
    public function getDonation($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'donation-news/list',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'donation-news/list?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10
                    ]
                ]);

            }else {
                $result = $this->client->request('GET', 'donation-news/list',
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
    		return $this->view->render($response, 'backend/admin/donation-news/index', [
                'data'      =>  $data->data,
                'base_url'  =>  "http://localhost:8000",
                'link'      =>  "http://localhost:8000/admin/donation-news/",
                'title'     =>  "Berita Donasi",
                'messages'  => $messages,
            ]);
        } else {
            return $this->view->render($response, 'backend/user/donation-news/index', [
                'data'      =>  $data->data,
                'base_url'  =>  "http://localhost:8000",
                'link'      =>  "http://localhost:8000/web/donation-news/",
                'title'     =>  "Berita Donasi",
                'messages'  => $messages,
            ]);
        }
    }

    public function getDonationDetailId($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'donation-news/'.$args['id'].
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'backend.user.donation-news.detail', [
            'data'      =>  $data->data,
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Read Berita Donasi"
        ]);
    }

    public function remove($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'donation-news/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('list.donasi'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.donasi'));
        }
    }

    public function getDonationNews($request, $response, $args)
    {
        return $this->view->render($response, 'backend/admin/donation-news/add', [
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Berita Donasi"
        ]);
    }

    public function addDonationNews($request, $response)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'donation-news/add',[
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                    [
                        'name'      =>  'title',
                        'contents'  =>  $request->getParam('title')
                    ],
                    [
                        'name'      =>  'content',
                        'contents'  =>  $request->getParam('content'),
                    ]
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('add.donasi'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.donasi'));
        }
    }

    public function geteditDonationNews($request, $response, $args)
    {
        $donasi = new DonationNews;
        $data = $donasi->where('id', $args['id'])->first();
        return $this->view->render($response, 'backend/admin/donation-news/edit', [
            'data'      =>  $data,
            'base_url'  =>  "http://localhost:8000",
            'title'     =>  "Berita Donasi"
        ]);
    }

    public function putDonationNews($request, $response, $args)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'donation-news/'.$args['id'].'/edit',[
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                    [
                        'name'      =>  'title',
                        'contents'  =>  $request->getParam('title')
                    ],
                    [
                        'name'      =>  'content',
                        'contents'  =>  $request->getParam('content'),
                    ]
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('edit.donasi'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.donasi'));
        }
    }
}
