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
        /**
         * How do we get our Controller here.We need to know the
         * kind of string that we get out of our function's parameter first.
         *
         * Taking note of the fact that we have defined our routes with
         * ControllerFullyQualifiedNamespace::route(methodName), that as
         * much as we know - nonetheless we can't invalidate the following
         * code listing.
         */
        if (false === str_contains($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        /**
         * Controller instance, in the end is vital and the method being
         * called on the controller. The question remains, how do we manage
         * still the parameters that need oto be injected onto the method
         * being called?
         *
         * This lie of code is the most vital.
         */
        list($class, $method) = explode('::', $controller, 2);

        /**
         * This code fragment is redundant as we are never reaching this point.
         */
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

        /**
         * This part never yield to anything either. It does get executed
         * but we do not get any value out of it. Our controllers are not
         * implementing the interface and ideally, they shouldn't.
         */
        if ($controller instanceof ContainerAwareInterface && $this->container instanceof Container) {
            $controller->setContainer($this->container);
        }

        return [$controller, $method];
    }
}