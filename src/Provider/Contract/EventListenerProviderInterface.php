<?php

declare(strict_types=1);

namespace Xylene\Provider\Contract;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Interface EventListenerProviderInterface
 *
 * @package Xylene\Provider\Contract
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
interface  EventListenerProviderInterface
{
    /**
     * @param HttpKernelInterface $app
     * @param EventDispatcherInterface $dispatcher
     * @return mixed
     */
    public function subscribe(HttpKernelInterface $app, EventDispatcherInterface $dispatcher): void;
}