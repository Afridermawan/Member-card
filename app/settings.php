<?php

$phpdotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$phpdotenv->load();

return [
    'settings' => [

        // Show error
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'addContentLengthHeader' => false,

        // Validator
        'lang' => [
            'default' => 'id',
        ],

        // Renderer settings
        'renderer'            => [
            'templates.path'        => __DIR__. '/../views',
            'debug'                 => true,
            'cache'                 => __DIR__. '/cache',
        ],

        // Elloquent
        'db' => [
            'driver'    => $_ENV['DB_DRIVER'],
            'host'      => $_ENV['DB_HOST'],
            'database'  => $_ENV['DB_DATABASE'],
            'username'  => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        'member-card' => [
           'base_uri' => 'http://localhost/Member-Card/public/api/',
           'headers' => [
            //    'key' => @$_ENV['REPORTING_API_KEY'],
               'Accept'         => 'application/json',
               'Content-Type'   => 'application/json',
               'Authorization'  => @$_SESSION['key']
           ],
      ],

      'deposit' => [
           'base_uri' => 'http://deposit.mlogg.com/api/',
           'headers' => [
               'Accept'         => 'application/json',
               'Content-Type'   => 'application/json',
               'Authorization'  => 'a70b2d2ef78255eac4512849d1f2640e22cce5b7a19acd80715d1af28b6349c82d71eafd61322486379e9faa0abca2c7ae3cfb6381efc6b8bc09bbc80b2523bb'
           ],
      ],

      'flysystem' => [
        'path'	=> __DIR__ . "/../public/assets",
       ]
    ],
];
