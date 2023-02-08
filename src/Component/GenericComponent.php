<?php

declare(strict_types=1);

namespace Xylene\Component;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * Class GenericComponent
 *
 * @package Xylene\Component
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
abstract class GenericComponent implements Component
{
    /** {@inheritDoc} */
    public function getFileLoader($paths, string $pointer): PhpFileLoader
    {
        return (new PhpFileLoader($container, new FileLocator($paths . $pointer)));
    }

    /** {@inheritDoc} */
    public function getAlias(): string
    {
        $className = static::class;
        if (!str_ends_with($className, 'Component')) {
            throw new BadMethodCallException('This Component does not follow the naming convention; you must overwrite the getAlias() method.');
        }
        $classBaseName = substr(strrchr($className, '\\'), 1, -9);

        return Container::underscore($classBaseName);
    }

    /** {@inheritDoc} */
    public function getNamespace(): string
    {
        return 'http://xylene.io/schema/component/' . $this->getAlias();
    }

    /** {@inheritDoc} */
    public function getXsdValidationBasePath(): bool|string
    {
        return false;
    }
}