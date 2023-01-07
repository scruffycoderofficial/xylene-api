<?php

use Xylene\Action\ActionResolver;
use Xylene\Foundation\Application;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Xylene\Console\Application as ConsoleApplication;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $configurator) {

    $services = $configurator->services()->defaults()->autowire()->autoconfigure();

    /**
     * Core namespace definitions through the service container
     */
    $services->load('Xylene\\', '../src/*');

    /**
     * Generic service definitions
     */
    $services->set('xylene.app.container', Container::class);
    $services->alias(ContainerInterface::class, 'xylene.app.container');

    /**
     * Compulsory and/or necessary framework definitions
     */
    $services->set('xylene.app.routes', RouteCollection::class);

    $services->set('xylene.app.events', EventDispatcher::class);
    $services->alias(EventDispatcherInterface::class, 'xylene.app.events');

    $services->set('xylene.app.action_resolver', ActionResolver::class);
    $services->alias(ControllerResolverInterface::class, 'xylene.app.action_resolver');

    $services->set('xylene.app.request_stack', RequestStack::class);

    $services->set('xylene.app.action_argument_resolver', ArgumentResolver::class);
    $services->alias(ArgumentResolverInterface::class, 'xylene.app.action_argument_resolver');

    /**
     * Definition of the main Application Kernel that handles responding
     * the Client Request setup
     */
    $services->set('xylene.app', Application::class)
        ->args([
            service('xylene.app.routes'),
            service('xylene.app.events'),
            service('xylene.app.action_resolver'),
            service('xylene.app.request_stack')
        ]);

    $services->alias(HttpKernelInterface::class, 'xylene.app')
        ->public();

    $services->instanceof(Command::class)->tag('console.command');

    $services->set(ConsoleApplication::class)->public()->args([ tagged_iterator('console.command') ]);
};