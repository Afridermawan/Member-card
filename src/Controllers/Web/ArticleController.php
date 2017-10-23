<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

/**
*
*/
class ArticleController extends Controller
{
    /**
    * Sample handler
    */
    public function getArticle($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'article',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'article?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10,
                    ]
                ]);

            }else {
                $result = $this->client->request('GET', 'article',
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
            return $this->view->render($response, 'backend/admin/article/index', [
                'data'      =>  $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/admin/article/",
                'title'     =>  "Artikel",
                'messages'  =>  $messages
            ]);
        } else {
            return $this->view->render($response, 'backend/user/article/index', [
                'data'      =>  $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/web/article/",
                'title'     =>  "Artikel",
                'messages'  =>  $messages
            ]);
        }
    }

    public function getArticleTag($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'article/tag',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 10,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'article/tag?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10,
                    ]
                ]);

            }else {
                $result = $this->client->request('GET', 'article/tag',
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
        return $this->view->render($response, 'backend/user/article/index', [
                'data'      =>  $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/web/article",
                'title'     =>  "Artikel",
                'messages'  =>  $messages
        ]);
    }

    public function getArticleTagId($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/tag/'.$args['id'].
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'backend/user/article/detail', [
                'data'      =>  $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/web/article",
                'title'     =>  "Read Artikel",
                'messages'  =>  $messages
        ]);
    }

    public function getArticleDetailId($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/'.$args['id'].'/detail'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        try {
            $result = $this->client->request('GET', 'article/comment/'.$args['id']);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $comment = json_decode($result->getBody()->getContents());

        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/article/detail', [
                'data'      =>  $data->data,
                'comment'   =>  $comment->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/web/article",
                'title'     =>  "Read Artikel",
                'messages'  =>  $messages
        ]);
    }

    public function getArticleDetailSlug($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/'.$args['slug'].
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, '/backend/admin/article/index', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/admin/article",
            'title'     =>  "Artikel"
        ]);
    }

    public function getCategory($request, $response)
    {
        try {
            $result = $this->client->request('GET', 'category/article'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, '/backend/admin/article/category', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/admin/category/article",
            'title'     =>  "Category"
        ]);
    }

    public function getCategoryDetail($request, $response, $args)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'category/article/'.$args['id'],
                [
                    'query' => [
                        'search' => $request->getParam('search')
                    ],
                    'headers' => [
                        'limit' => 10
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'category/article/'.$args['id'].'?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 10,
                    ]
                ]);
            } else {
                $result = $this->client->request('GET', 'category/article/'.$args['id'],
                [
                    'headers' => [
                        'limit' => 10
                    ]
                ]);
            }

        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'backend/user/article/index', [
                'data'      =>  $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/web/article",
                'title'     =>  "Artikel",
                'messages'  =>  $messages
        ]);
    }

    public function getCategoryArticle($request, $response)
    {
        try {
            $result = $this->client->request('GET', 'category_article'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'article/detail.twig', [
            'data'	=> $data['data']
        ]);
    }

    public function getComment($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/'.$args['id'].'/comment');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/article/detail', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/web/article",
            'title'     =>  "Artikel",
            'messages'  =>  $messages
        ]);
    }

    public function getCommentByAdmin($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/'.$args['id'].'/comment');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/admin/article/replay-comment', [
            'comment'   =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/admin/article/",
            'title'     =>  "Artikel",
            'messages'  =>  $messages
        ]);
    }

    public function postComment($request, $response, $args)
    {
        $session = $_SESSION['login'];

        try {
            $result = $this->client->request('POST', 'article/'.$args['id'].'/comment',[
                'form_params' => [
                    'article_id'          =>  $args['id'],
                    'user_id'             =>  $session->user_id,
                    'comment'             =>  $request->getParam('comment'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if ($session->role_id == 1) {
            return $response->withRedirect($this->router->pathFor('get.comment'));
        } else {
            return $response->withRedirect($this->router->pathFor('detail.article',['id' => $args['id']]));
        }
    }

    public function destroy($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.article'));
    }

    public function getArticleComment($request, $response)
    {
        try {
            $result = $this->client->request('GET', 'comment/article'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, '/backend/admin/article/comment', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/admin/article/",
            'title'     =>  "Comments"
        ]);
    }

    public function getAddArticle($request, $response, $args)
    {
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/admin/article/add', [
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/admin/article",
                'title'     =>  "Artikel",
                'messages'  =>  $messages
        ]);
    }

    public function postArticle($request, $response, $args)
    {
        $path   = $_FILES['thumbnail']['tmp_name'];
        $mime   = $_FILES['thumbnail']['type'];
        $name   = $_FILES['thumbnail']['name'];
        try {
            $result = $this->client->request('POST', 'article',[
                'multipart' => [
                    [
                        'name'     => 'thumbnail',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                ],
                'query' => [
                    'title'     =>  $request->getParam('title'),
                    'content'   =>  $request->getParam('content'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('add.article'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.article'));
        }
    }

    public function getEditArticle($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'article/'.$args['id'].'/detail'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/admin/article/edit', [
                'data'      =>  $data->data,
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'link'      =>  "https://8de60e5a.ngrok.io/admin/article",
                'title'     =>  "Artikel",
                'messages'  =>  $messages
        ]);
    }

    public function putArticle($request, $response, $args)
    {
        $path   = $_FILES['thumbnail']['tmp_name'];
        $mime   = $_FILES['thumbnail']['type'];
        $name   = $_FILES['thumbnail']['name'];
        try {
            $result = $this->client->request('POST', 'article',[
                'multipart' => [
                    [
                        'name'     => 'thumbnail',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                ],
                'query' => [
                    'title'     =>  $request->getParam('title'),
                    'content'   =>  $request->getParam('content'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('add.article'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.article'));
        }
    }

}
