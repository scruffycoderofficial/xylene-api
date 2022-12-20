<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core\Controller;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;

class ControllerResolver extends BaseControllerResolver
{
    protected $container;

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

            return array($controller, $method);
        }

        /**
         * @TODO Shouldn't be necessary to enforce a superclass for the
         *       sake of gaining access to the Container in one way. Also
         *       Symfony's ContainerAware interface takes care of the setter
         *       method as an alternative to Dependency Injection(see below
         *       code fragment).
         */
        $controller = new $class($this->container);

        if ($controller instanceof ContainerAwareInterface && $this->container instanceof Container) {
            $controller->setContainer($this->container);
        }

        return [$controller, $method];
    }
}