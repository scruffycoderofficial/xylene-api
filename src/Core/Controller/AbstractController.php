<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core\Controller;

use Psr\Container\ContainerInterface;

/**
 * Class AbstractController
 *
 * @package OffCut\RestfulApi\Core\Controller
 */
class AbstractController
{
    protected $container;

    /**
     * StocksController constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}