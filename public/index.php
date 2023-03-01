<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Xylene\Container;

date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

try
{
    (new Dotenv())->load(__DIR__ . '/../.env');

    $container = Container::buildContainer(dirname(__DIR__, 1));

    if (!$container->isCompiled()) {
        $container->compile();
    }

    $response = $container->get('response');

    $response->send();

    $container->get('http_kernel')->terminate($container->get('request'), $response);

} catch(\Exception $exc) {
    echo $exc->getMessage();
}