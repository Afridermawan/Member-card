<?php

$container = $app->getContainer();

// Elloquent
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};

$container['auth'] = function ($c) {
    return new App\Controllers\Api\UserController($c);
};

// Register Blade View helper
$container['view'] = function ($container) {
    return new \Slim\Views\Blade(
        $container['settings']['renderer']['templates.path'],
        $container['settings']['renderer']['cache']
    );

    $view->getEnvironment()->addGlobal('old', @$_SESSION['old']);
    unset($_SESSION['old']);
    $view->getEnvironment()->addGlobal('errors', @$_SESSION['errors']);
    unset($_SESSION['errors']);
    if (@$_SESSION['login']) {
      $view->getEnvironment()->addGlobal('login', $_SESSION['login']); 
    }
    if (@$_SESSION['produk']) {
      $view->getEnvironment()->addGlobal('produk', $_SESSION['produk']);
    }
    if (@$_SESSION['pin']) {
      $view->getEnvironment()->addGlobal('pin', $_SESSION['pin']);
    }
    if (@$_SESSION['event']) {
      $view->getEnvironment()->addGlobal('event', $_SESSION['event']);
    }
    if (@$_SESSION['search']) {
      $view->getEnvironment()->addGlobal('search', $_SESSION['search']);
      // unset($_SESSION['search']);
    }
    if (@$_SESSION['back']) {
      $view->getEnvironment()->addGlobal('back', $_SESSION['back']);
    }

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

// Validator
$container['validator'] = function ($c) {
    $settings = $c->get('settings');

    $params = $c['request']->getParams();

    return new Valitron\Validator($params, [], $settings['lang']['default']);
};

// Flash
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages();
};

// Csrf
$container['csrf'] = function ($c) {
    return new Slim\Csrf\Guard;
};

//client
$container['client'] = function ($container) {
   $settings = $container->get('settings')['member-card'];

   return new GuzzleHttp\Client([
       'base_uri' => $settings['base_uri'],
       'headers'  => $settings['headers']
   ]);
};

$container['client_deposit'] = function ($container) {
   $settings = $container->get('settings')['deposit'];

   return new GuzzleHttp\Client([
       'base_uri' => $settings['base_uri'],
       'headers'  => $settings['headers']
   ]);
};

$container['fs'] = function ($c) {
	$setting = $c->get('settings')['flysystem'];
    $adapter = new \League\Flysystem\Adapter\Local($setting['path']);
    $filesystem = new \League\Flysystem\Filesystem($adapter);
    return $filesystem;
};

//url_api
$container['url_api'] = function ($c) {
        return 'http://localhost:8000/api';
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
		return $response->withRedirect($request->getUri()->getBasePath().'/404');
    };
};

 Veritrans_Config::$serverKey = 'VT-server-k7fH1US2t9bitNSBNjzQaLLv';
