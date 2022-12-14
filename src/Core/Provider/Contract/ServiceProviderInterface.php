<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core\Provider\Contract;

use Psr\Container\ContainerInterface;

/**
 * Interface ServiceProviderInterface
 *
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