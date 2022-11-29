<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$container = new ContainerBuilder();

(new PhpFileLoader($container, new FileLocator(__DIR__)))
    ->load('services.php');

$container->compile();

return $container;