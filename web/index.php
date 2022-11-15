<?php

declare(strict_types=1);

use OffCut\RestfulApi\Core\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$loader = require __DIR__ . '/../vendor/autoload.php';

$loader->register();

$request = Request::createFromGlobals();

$app = new \OffCut\RestfulApi\Core\App();

/**
 * Routing
 */
$app->map('/', function () {
    return new Response('This is the home page');
});

$app->map('/about', function () {
    return new Response('This is the about page');
});

/**
 * Eventing
 */
$app->on('request', function (RequestEvent $event) {
    if ('admin' == $event->getRequest()->getPathInfo()) {
        echo 'Access Denied!';
        exit;
    }
});

/**
 * Client response
 */
$response = $app->handle($request);
