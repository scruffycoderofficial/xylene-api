<?php

declare(strict_types=1);

namespace Xylene\Demo;

use Exception;
use Xylene\Controller\FrontController;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * Class AppKernel
 *
 * @package Xylene\Demo
 */
final class DemoFrontController extends FrontController
{
    public function __construct(ContainerBuilder $container = null)
    {
        parent::__construct($container);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        try {

            $loader = (new PhpFileLoader($container, new FileLocator(__DIR__ . '/../')));

            $loader->load('parameters.php');
            $loader->load('services.php');

        } catch(Exception $exc) {

        }
    }

    /**
     * @return object
     * @throws Exception
     */
    public function getApplication(): object
    {
        $app = null;

        try {

            $app = $this->container
                ->get('xylene.app');

            $app->setContainer($this->container);

        } catch(Exception $exc) {

        } finally {

            if (!is_null($app)) {
                return $app;
            } else {
                throw new Exception('No Application available.');
            }
        }
    }



    /**
     * Loads the file that configures Service Providers
     */
    protected function loadServiceProviders(): void
    {
        try {

            $app = $this->getApplication();

            require_once __DIR__ . '/../providers.php';

        } catch (Exception $exc) {

        }
    }

    /**
     * Loads the file that configures Routes
     */
    protected function loadRoutes(): void
    {
        try {

            $app = $this->getApplication();

            $this->loadAboutRoute($app);

            require_once __DIR__ . '/../routes.php';

        } catch (Exception $exc) {

        }
    }
}