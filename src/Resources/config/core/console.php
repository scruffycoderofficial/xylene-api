<?php

declare(strict_types=1);

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

/**
 * @param ContainerConfigurator $configurator
 */
return static function (ContainerConfigurator $configurator)
{
    $configurator->services()

        ->instanceof(Command::class)->tag('console.command')

        ->set(ConsoleApplication::class)->public()->args(arguments: [
            tagged_iterator('console.command')
        ]);
};