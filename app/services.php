<?php

use OffCut\RestfulApi\Console\App;
use OffCut\RestfulApi\Core\AppKernel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $configurator) {

    $services = $configurator->services()->defaults()->autowire()->autoconfigure();

    $services->instanceof(Command::class)->tag('console.command');

    $services->load('OffCut\\RestfulApi\\', '../src/*');

    $services->set('offcut_solutions.api.routes', RouteCollection::class);

    $services->set('offcut_solutions.api.events', EventDispatcher::class);
    $services->alias(EventDispatcherInterface::class, 'offcut_solutions.api.events');

    $services->set('offcut_solutions.api.controller_resolver', ControllerResolver::class);
    $services->alias(ControllerResolverInterface::class, 'offcut_solutions.api.controller_resolver');

    $services->set('offcut_solutions.api.request_stack', RequestStack::class);

    $services->set('offcut_solutions.api.controller_argument_resolver', ArgumentResolver::class);
    $services->alias(ArgumentResolverInterface::class, 'offcut_solutions.api.controller_argument_resolver');

    $services->set('offcut_solutions.api.app', AppKernel::class)
        ->args([
            service('offcut_solutions.api.routes'),
            service('offcut_solutions.api.events'),
            service('offcut_solutions.api.controller_resolver'),
            service('offcut_solutions.api.request_stack')
        ]);
    $services->alias(HttpKernelInterface::class, 'offcut_solutions.api.app')
        ->public();

    $services->set(App::class)->public()->args([ tagged_iterator('console.command') ]);
};