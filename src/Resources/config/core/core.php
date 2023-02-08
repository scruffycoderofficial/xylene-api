<?php

declare(strict_types=1);

use Xylene\Action\ActionResolver;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @param ContainerConfigurator $configurator
 */
return static function (ContainerConfigurator $configurator)
{
    $configurator->services()

        ->set('xylene.app.routes', RouteCollection::class)

        ->set('xylene.app.events', EventDispatcher::class)
        ->alias(EventDispatcherInterface::class, 'xylene.app.events')

        ->set('xylene.app.action_resolver', ActionResolver::class)
            ->args([
            service('xylene.app.container')
        ])
        ->alias(ControllerResolverInterface::class, 'xylene.app.action_resolver')

        ->set('xylene.app.request_stack', RequestStack::class);
};