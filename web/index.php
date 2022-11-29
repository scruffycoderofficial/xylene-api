<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/../.env');

$request = Request::createFromGlobals();

$container = (require __DIR__ . '/../app/container.php');

$app = $container->get(HttpKernelInterface::class);

require __DIR__ . '/../app/routes.php';

($app->handle($request))->send();