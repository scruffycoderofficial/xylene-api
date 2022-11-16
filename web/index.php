<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Request initialization
 */
$request = Request::createFromGlobals();

/**
 * Application initialization
 */
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

$app->map('/cases', \OffCut\RestfulApi\Controller\CasesController::class . '::indexAction');

/**
 * Client response
 */
($app->handle($request))->send();