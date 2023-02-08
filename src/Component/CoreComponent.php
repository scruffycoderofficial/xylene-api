<?php

declare(strict_types=1);

namespace Xylene\Component;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * Class CoreComponent
 *
 * @package Xylene\Component
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class CoreComponent extends GenericComponent
{
    /**
     * Name of this extension
     */
    const NAME = 'core';

    /** {@inheritDoc} */
    public function getFileLoader($paths, string $pointer = self::NAME): PhpFileLoader
    {
        return parent::getFileLoader($paths, $pointer);
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @return void
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        try {

            $loader = (new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/' . self::NAME)));

            // NOTE: Order of resource loading is important here

            $loader->load('core.php');
            $loader->load('app.php');
            $loader->load('console.php');

        } catch (Exception $e) {

            throw new Exception('Core File Locator has invalid Resource pointer.');
        }
    }

    /** {@inheritDoc} */
    public function getAlias(): string
    {
        return parent::getAlias();
    }
}