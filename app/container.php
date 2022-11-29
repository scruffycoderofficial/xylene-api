<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$container = new ContainerBuilder();

try {

    (new PhpFileLoader($container, new FileLocator(__DIR__)))
        ->load('services.php');

} catch (Exception $e) {
}

$container->compile();

return $container;