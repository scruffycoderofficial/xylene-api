<?php

use OffCut\RestfulApi\Console\App;
use OffCut\RestfulApi\Core\App as WebApp;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $configurator) {

    $services = $configurator->services()->defaults()->autowire()->autoconfigure();

    $services->load('OffCut\\RestfulApi\\', '../src/*');

    $services->set('offcut_solutions.api.app', WebApp::class)
        ->autowire(false)
        ->public();

    $services->alias(HttpKernelInterface::class, 'offcut_solutions.api.app')
        ->public();

    $services->set(App::class)->public()->args([ tagged_iterator('console.command') ]);
};