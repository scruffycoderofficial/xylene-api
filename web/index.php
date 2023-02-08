<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Xylene\Demo\DemoFrontController;

require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/../.env');

try {

    ((new DemoFrontController())->getApplication()->handle(Request::createFromGlobals()))->send();

} catch (Exception $e) {
}

