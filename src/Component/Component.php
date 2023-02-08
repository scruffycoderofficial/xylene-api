<?php

declare(strict_types=1);

namespace Xylene\Component;

use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * Interface Component
 *
 * @package Xylene\Component
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
interface Component extends ExtensionInterface
{
    /**
     * @param $paths
     * @param string $pointer
     * @return PhpFileLoader
     */
    public function getFileLoader($paths, string $pointer): PhpFileLoader;
}