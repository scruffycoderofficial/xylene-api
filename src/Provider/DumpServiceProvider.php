<?php

declare(strict_types=1);

namespace Xylene\Provider;

use Psr\Container\ContainerInterface;
use Xylene\Provider\Contract\ServiceProviderInterface;

/**
 * Class DumpServiceProvider
 *
 * @package Xylene\Provider
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class DumpServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void
    {
    }
}