<?php

use OffCut\RestfulApi\Console\App;
use OffCut\RestfulApi\Core\App as WebApp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\EventDispatcher;
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

    $services->set('offcut_solutions.api.app', WebApp::class)
        ->args([
            service('offcut_solutions.api.routes'),
            service('offcut_solutions.api.events')
        ]);

    $services->alias(HttpKernelInterface::class, 'offcut_solutions.api.app')
        ->public();

    $services->set(App::class)->public()->args([ tagged_iterator('console.command') ]);
};