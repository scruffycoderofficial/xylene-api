<?php

declare(strict_types=1);

namespace Xylene\Action;

use Exception;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class ActionResolver
 *
 * @package Xylene\Action
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class ActionResolver extends ControllerResolver
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * ActionResolver constructor.
     *
     * @param ContainerInterface $container
     * @param LoggerInterface|null $logger
     */
    public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
    {
        $this->container = $container;

        parent::__construct($logger);
    }

    /**
     * @param string $controller
     * @return callable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    protected function createController(string $controller): callable
    {
        if (false === str_contains($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method) = explode('::', $controller, 2);

        if (!class_exists($class)) {

            if (!$this->container->has($class)) {
                throw new Exception(sprintf('Class "%s" could not be resolved from Container.', $class));
            }

            $controller = $this->container->get($class);

            return [$controller, $method];
        }

        $controller = new $class($this->container);

        if ($controller instanceof ContainerAwareInterface && $this->container instanceof Container) {
            $controller->setContainer($this->container);
        }

        return [$controller, $method];
    }
}