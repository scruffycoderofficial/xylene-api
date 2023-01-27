<?php

declare(strict_types=1);

use Xylene\Foundation\Application;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @param ContainerConfigurator $configurator
 */
return static function (ContainerConfigurator $configurator)
{
    $configurator->services()

        ->set('xylene.app.container', Container::class)
        ->alias(ContainerInterface::class, 'xylene.app.container')

        ->set('xylene.app', Application::class)
            ->args([
                service('xylene.app.routes'),
                service('xylene.app.events'),
                service('xylene.app.action_resolver'),
                service('xylene.app.request_stack')
            ])

        ->alias(HttpKernelInterface::class, 'xylene.app')
        ->public();
};