<?php

declare(strict_types=1);

namespace Xylene\Controller;

use PHPUnit\Exception;
use Xylene\Action\AboutActionHandler;
use Xylene\Component\CoreComponent;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Xylene\Foundation\Application;

/**
 * Class FrontController
 *
 * @package Xylene\Controller
 */
abstract class FrontController
{
    /**
     * @var ContainerBuilder $container
     */
    protected $container;

    /**
     * FrontController constructor.
     *
     * @param ContainerBuilder|null $builder
     */
    public function __construct(ContainerBuilder $builder = null)
    {
        $this->container = is_null($builder) ? new ContainerBuilder() : $builder;

        $this->load([], $this->container);

        $this->loadServiceProviders();

        $this->loadExtensions($this->container);

        $this->loadRoutes();
    }

    private function loadExtensions($container)
    {
        $coreComponent = new CoreComponent();

        try {

            $coreComponent->load([], $container);

        } catch (\Exception $e) {

        } finally {
            $container->registerExtension($coreComponent);
        }
    }

    protected function loadAboutRoute(Application $app)
    {
        $app->map('/about', 'Xylene\Action\AboutActionHandler::index');
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    abstract public function load(array $configs, ContainerBuilder $container);

    /**
     * @return void
     */
    abstract protected function loadServiceProviders(): void;

    /**
     * @return void
     */
    abstract protected function loadRoutes(): void;
}