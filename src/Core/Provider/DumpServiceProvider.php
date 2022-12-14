<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core\Provider;

use Psr\Container\ContainerInterface;
use OffCut\RestfulApi\Core\Provider\Contract\ServiceProviderInterface;

/**
 * Class DumpServiceProvider
 *
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