<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdminMiddleware extends BaseMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $session = $_SESSION['login'];
        if ($session->role_id == 1) {

            $response = $next($request, $response);

            return $response;
        } elseif($session->role_id == 2) {
            $this->container->flash->addMessage('error', 'Maaf Anda bukan Admin !');
            return $response->withRedirect($this->container->router->pathFor('login.admin'));
        } else {
            $this->container->flash->addMessage('info', 'Anda harus login untuk mengakses halam ini !');
            return $response->withRedirect($this->container->router->pathFor('login.admin'));
        }
    }
}
