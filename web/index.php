<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Request initialization
 */
$request = Request::createFromGlobals();

/**
 * Application initialization
 */
$app = new \OffCut\RestfulApi\Core\App();

require __DIR__ . '/../app/routes.php';

/**
 * Client response
 */
($app->handle($request))->send();