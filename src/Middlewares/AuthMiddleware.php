<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthMiddleware extends BaseMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $session = $_SESSION['login'];

        if ($session->role_id == 2) {
            
            $response = $next($request, $response);

            return $response;
        } else {
            $this->container->flash->addMessage('info', 'Anda harus login untuk mengakses halaman ini!');

            return $response->withRedirect($this->container->router->pathFor('login'));
        }
    }
}
