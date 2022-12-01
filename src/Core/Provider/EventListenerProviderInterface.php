<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core\Provider;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Interface EventListenerProviderInterface
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
interface  EventListenerProviderInterface
{
    /**
     * @param ContainerInterface $app
     * @param EventDispatcherInterface $dispatcher
     * @return mixed
     */
    public function subscribe(ContainerInterface $app, EventDispatcherInterface $dispatcher): void;
}