<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/../.env');

$request = Request::createFromGlobals();

$container = (require __DIR__ . '/../config/container.php');

$app = $container->get(HttpKernelInterface::class);

$app->setContainer($container);

require __DIR__ . '/../config/providers.php';
require __DIR__ . '/../config/routes.php';

$container->compile();

($app->handle($request))->send();