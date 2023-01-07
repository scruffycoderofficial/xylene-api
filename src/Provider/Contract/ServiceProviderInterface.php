<?php

declare(strict_types=1);

namespace Xylene\Provider\Contract;

use Psr\Container\ContainerInterface;

/**
 * Interface ServiceProviderInterface
 *
 * @package Xylene\Provider\Contract
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
interface ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void;
}