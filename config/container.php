<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$container = new ContainerBuilder();

try {

    $loader = (new PhpFileLoader($container, new FileLocator(__DIR__)));

    $loader->load('parameters.php');
    $loader->load('services.php');

} catch (Exception $e) {
}

return $container;