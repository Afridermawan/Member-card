<?php

namespace App\Controllers\Web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use App\Models\User;

/**
*
*/
class UserController extends Controller
{
    /**
    * Sample handler
    */
    public function getUser($request, $response)
    {
        try {
            if ($request->getParam('search')) {
                $result = $this->client->request('GET', 'user/list',
                    [
                        'query' => [
                            'search' => $request->getParam('search')],
                        'headers' => [
                            'limit' => 5,
                    ]
                ]);
            } elseif ($request->getQueryParam('page')) {
                $result = $this->client->request('GET', 'user/list?page='.$request->getQueryParam('page'),
                [
                    'headers' => [
                        'limit' => 5
                    ]
                ]);

            }else {
                $result = $this->client->request('GET', 'user/list',
                    [
                        'headers' => [
                            'limit' => 5,
                    ]
                ]);
            }

		} catch (GuzzleException $e) {
			$result = $e->getResponse();
		}

        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

		return $this->view->render($response, 'backend/admin/user/index', [
            'data'      =>  $data->data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'link'      =>  "https://8de60e5a.ngrok.io/admin/user/",
            'title'     =>  "Pengguna",
            'messages'  =>  $messages
        ]);
    }

    public function getUserDetail($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'user/'.$args['id'].'/detail'.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $this->view->render($response, 'article/detail.twig', [
            'data'	=> $data['data']
        ]);
    }

    public function delete($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'user/'.$args['id'].'/delete');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.user'));
    }

    public function restore($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'user/'.$args['id'].'/restore');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        return $response->withRedirect($this->router->pathFor('list.user'));
    }

    public function getAddUser($request, $response)
    {
        return $this->view->render($response, 'backend/user/auth/register', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Register"
        ]);
    }

    public function register($request, $response)
    {
        $query = $request->getQueryParams();
        try {
            $result = $this->client->request('POST', 'auth/signup',[
                'form_params' => [
                    'username'              =>  $request->getParam('username'),
                    'email'                 =>  $request->getParam('email'),
                    'password'              =>  $request->getParam('password'),
                    'phone'                 =>  $request->getParam('phone'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('register'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }

    public function getPutUser($request, $response, $args)
    {
        $user = new User;
        $data = $user->where('id', $args['id'])->first();
        return $this->view->render($response, 'backend/admin/user/edit', [
            'data'      =>  $data,
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Pengguna"
        ]);
    }

    public function putUser($request, $response, $args)
    {
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'user/'.$args['id'].'/edit',[
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                    [
                        'name'      =>  'username',
                        'contents'  =>  $request->getParam('username')
                    ],
                    [
                        'name'      =>  'gender',
                        'contents'  =>  $request->getParam('gender'),
                    ],
                    [
                        'name'      =>  'name',
                        'contents'  =>  $request->getParam('name'),
                    ],
                    [
                        'name'      =>  'email',
                        'contents'  =>  $request->getParam('email'),
                    ],
                    [
                        'name'      =>  'password',
                        'contents'  =>  $request->getParam('password'),
                    ],
                    [
                        'name'      =>  'phone',
                        'contents'  =>  $request->getParam('phone'),
                    ],
                    [
                        'name'      =>  'address',
                        'contents'  =>  $request->getParam('address'),
                    ],
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('edit.user'));
        } else {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('list.user'));
        }
    }

    public function getLoginAsAdmin($request, $response)
    {
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/admin/auth/login', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Login Admin",
            'messages'  =>  $messages
        ]);
    }
     public function loginAsAdmin($request, $response)
    {
        try {
            $result = $this->client->request('POST', 'auth/signin',
                ['form_params' => [
                    'username' => $request->getParam('username'),
                    'password' => $request->getParam('password')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents());

        if ($data->data->role_id == 1) {
            $_SESSION['login'] = $data->data;
            $_SESSION['key'] = $data->data->token;

            if ($data->data->role_id == 1 && $data->code == 200) {
                $this->flash->addMessage('success', $data->message);
                return $response->withRedirect($this->router->pathFor('home.admin'));
            } else {
                $this->flash->addMessage('error',
                'Anda belum terdaftar sebagai user atau akun anda belum diverifikasi');
                return $response->withRedirect($this->router->pathFor('login.admin'));
            }
        } elseif ($data->data->role_id == 2) {
            $this->flash->addMessage('error', 'Maaf, anda bukan Admin !');
            return $response->withRedirect($this->router->pathFor('login.admin'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('login.admin'));
        }
    }
    public function logout($request, $response)
    {
        $session = $_SESSION['login'];
        if ($session->role_id == 1) {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('login.admin'));
        } elseif ($session->role_id == 2) {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }

    public function getLogin($request, $response)
    {
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/auth/login', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Login",
            'messages'  =>  $messages
        ]);
    }
     public function login($request, $response)
    {
        try {
            $result = $this->client->request('POST', 'auth/signin',
                ['form_params' => [
                    'username' => $request->getParam('username'),
                    'password' => $request->getParam('password')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents());

        if ($data->data->role_id == 2) {
            $_SESSION['login'] = $data->data;
            $_SESSION['key'] = $data->data->token;

            if ($data->data->role_id == 2) {
                $this->flash->addMessage('success', $data->message);
                return $response->withRedirect($this->router->pathFor('home.user'));
            } else {
                $this->flash->addMessage('error',
                'Anda belum terdaftar sebagai user atau akun anda belum diverifikasi');
                return $response->withRedirect($this->router->pathFor('login'));
            }
        } elseif ($data->data->role_id == 1) {
            $this->flash->addMessage('error', 'Maaf, anda bukan user !');
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }

    public function get($request, $response, $args)
    {
        $messages = $this->flash->getMessages();

        return $this->view->render($response, 'backend/user/auth/verification', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Lupa Password",
            'messages'  =>  $messages
        ]);
    }
    public function forgotPassword($request, $response, $args)
    {
        try {
            $result = $this->client->request('POST', 'reset',
                ['form_params' => [
                    'email' => $request->getParam('email')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents());

        if ($data->error == false) {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }
    public function resetPassword($request, $response, $args)
    {
        try {
            $result = $this->client->request('POST', 'password/reset',
                ['form_params' => [
                    'token'         => $request->getParam('token'),
                    'email'         => $request->getParam('email'),
                    'password'      => $request->getParam('password'),
                    'password2'     => $request->getParam('password2')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents());

        if ($data->error == false) {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            $_SESSION['errors'] = $data->message;
            $_SESSION['old'] = $request->getParams();
            return  $this->view->render($response, 'backend/user/auth/reset-password', [
                'token' =>  $request->getParam('token')
            ]);
        }
    }

    public function getResetPassword($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'password/reset/'.$args['token']);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents());
        $messages = $this->flash->getMessages();

        if ($data->error == false) {
            return  $this->view->render($response, 'backend/user/auth/reset-password',[
                'data'      =>  $data->data,
                'title'     =>  'Reset Password',
                'base_url'  =>  "https://8de60e5a.ngrok.io",
                'messages'  =>  $messages
            ]);

        } else {
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }

    public function activateaccount($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'activateaccount/'.$args['token']);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents());

        if ($data->data->error == false) {
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }

    public function profile($request, $response)
    {
        $messages = $this->flash->getMessages();
        $session = $_SESSION['login'];
        try {
            $result = $this->client->request('GET', 'pin/'.$session->id.
            $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());
        $_SESSION['pin'] = $data->data->pin;

        return $this->view->render($response, 'backend/user/user/detail', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Profile",
            'messages'  =>  $messages,
            'session'   =>  $session,
            'pin'       =>  $_SESSION['pin'],
        ]);
    }

    public function getProfile($request, $response)
    {
        $messages = $this->flash->getMessages();
        $session = $_SESSION['login'];

        return $this->view->render($response, 'backend/user/user/edit', [
            'base_url'  =>  "https://8de60e5a.ngrok.io",
            'title'     =>  "Edit Profile",
            'messages'  =>  $messages,
            'session'   =>  $session
        ]);
    }

    public function editProfile($request, $response, $args)
    {
        $session = $_SESSION['login'];

        try {
            $result = $this->client->request('POST', 'user/'.$session->id.'/edit/profile',[
                'form_params' => [
                    'username'              =>  $request->getParam('username'),
                    'name'                  =>  $request->getParam('name'),
                    'gender'                =>  $request->getParam('gender'),
                    'email'                 =>  $request->getParam('email'),
                    'phone'                 =>  $request->getParam('phone'),
                    'address'               =>  $request->getParam('address')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('edit.profile'));
        } else {
            $_SESSION['login'] = $data->data;
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        }
    }

    public function postImage($request, $response, $args)
    {
        $session = $_SESSION['login'];
        $path   = $_FILES['image']['tmp_name'];
        $mime   = $_FILES['image']['type'];
        $name   = $_FILES['image']['name'];
        try {
            $result = $this->client->request('POST', 'user/change/image',[
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                    [
                        'name'     => 'user_id',
                        'contents'  => $session->user_id,
                    ]
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

        if($data->error == true) {
            $this->flash->addMessage('error', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        } else {
            $data->data = $_SESSION['login'];
            $this->flash->addMessage('success', $data->message);
            return $response->withRedirect($this->router->pathFor('profile'));
        }
    }
}
