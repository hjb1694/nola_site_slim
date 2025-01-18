<?php

use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = DotEnv::createImmutable(__DIR__);
$dotenv->load();

require './router/router.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$renderer = new PhpRenderer(__DIR__ . '/views');

use_router($app, $renderer);

$app->run();


?>