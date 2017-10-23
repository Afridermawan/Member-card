<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use  App\Models\Produk;

/**
*
*/
class ProdukController extends Controller
{
    /**
    * Sample handler
    */
    public function getProduk($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'produk/list',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'produk/list?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10,
                    ]
                ]);
            } else {
                $result = $this->client->request('GET', 'produk/list',
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
    		return $this->view->render($response, 'backend/admin/produk/index', [
                'data'      => $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/admin/produk/",
                'title'     =>  "Produk",
                'messages'  =>  $messages
            ]);
        } else {
            return $this->view->render($response, 'backend/user/produk/index', [
                'data'      => $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/web/produk/",
                'title'     =>  "Produk",
                'messages'  =>  $messages
            ]);
        }
    }

    public function getProdukDetailId($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'produk/'.$args['id'].'/find'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        return $this->view->render($response, 'article/detail.twig', [
            'data'	=> $data['data']
        ]);
    }

    public function getProdukDetailSlug($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'produk/'.$args['slug'].'/detail'.
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
            $result = $this->client->request('GET', 'produk/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.produk'));
    }

    public function listItems($request, $response, $args)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'produk/list/items',
                    [
                        'headers' => [
                            'limit' => 2,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'produk/list/items?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10
                    ]
                ]);
            } else {
                $result = $this->client->request('GET', 'produk/list/items',
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

        return $this->view->render($response, 'backend/admin/produk/penjualan', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/admin/list/items",
            'title'     =>  "Produk"
        ]);
    }

    public function restore($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'produk/'.$args['id'].'/restore');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.produk'));
    }

    public function removeBuyerProduct($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'produk/'.$args['id'].'/remove/produk/item');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.produk'));
    }

    public function getAddProduk($request, $response)
    {
        return $this->view->render($response, 'backend/admin/produk/add', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Produk"
        ]);
    }

    public function addProduk($request, $response)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'produk/add',[
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
                        'name'      =>  'harga',
                        'contents'  =>  $request->getParam('harga'),
                    ],
                    [
                        'name'      =>  'description',
                        'contents'  =>  $request->getParam('description'),
                    ],
                    [
                        'name'      =>  'stok',
                        'contents'  =>  $request->getParam('stok'),
                    ],
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('add.produk'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.produk'));
        }
    }

    public function getEditProduk($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'produk/'.$args['id'].'/find'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'backend/admin/produk/edit', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Produk"
        ]);
    }

    public function putProduk($request, $response, $args)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'produk/'.$args['id'].'/edit',[
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
                        'name'      =>  'harga',
                        'contents'  =>  $request->getParam('harga'),
                    ],
                    [
                        'name'      =>  'description',
                        'contents'  =>  $request->getParam('description'),
                    ],
                    [
                        'name'      =>  'stok',
                        'contents'  =>  $request->getParam('stok'),
                    ],
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('edit.produk'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.produk'));
        }
    }

    public function getBuyProduk($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'produk/'.$args['id'].'/find'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/produk/penjualan', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Beli Produk",
            'messages'  =>  $messages
        ]);
    }

    public function buy($request, $response, $args)
    {
        try {
            $result = $this->client->request('POST', 'produk/'.$args['id'].'/buy',[
                'form_params' => [
                    'user_id'              =>  $session->user_id,
                    'produk_id'            =>  $args['id'],
                    'kuantitas'            =>  $request->getParam('kuantitas'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        $_SESSION['produk'] = $data->data;

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('beli.produk'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('detail.pembelian.produk', [
                'id' => $args['id']]));
        }
    }

    public function findItems($request, $response, $args)
    {
        $produk = $_SESSION['produk'];
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/produk/detail-penjualan', [
            'produk'      =>  $produk,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Detail Pembelian",
            'messages'  =>  $messages
        ]);
    }

    public function bayar($request, $response, $args)
    {
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/produk/bayar', [
            'produk'      => $produk,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Bayar",
            'messages'  =>  $messages
        ]);
    }
}
