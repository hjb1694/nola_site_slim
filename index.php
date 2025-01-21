<?php

use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';

$dotenv = DotEnv::createImmutable(__DIR__);
$dotenv->load();

require './router/router.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$twig = Twig::create(__DIR__ . '/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

use_router($app);

$app->run();


?>