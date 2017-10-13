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
               'Accept' => 'application/json',
               'Content-Type' => 'application/json',
               'Authorization' => @$_SESSION['key']
           ],
      ],

      'flysystem' => [
        'path'	=> __DIR__ . "/../public/assets",
       ]
    ],
];
