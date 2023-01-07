<?php

declare(strict_types=1);

namespace Xylene\Action;

use Psr\Container\ContainerInterface;

/**
 * Class ActionHandler
 *
 * @package Xylen\Action
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
abstract class ActionHandler
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * StocksController constructor.
     *
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->registerEvents();
    }

    /**s
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param array $vents
     * @return mixed
     */
    abstract public function registerEvents($vents = []): void;
}