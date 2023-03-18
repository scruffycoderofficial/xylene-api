<?php

declare(strict_types=1);

namespace Xylene;

use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DefaultYamlFileLoader;
use Xylene\CompilerPass\RouterTagCompilerPass;

/**
 * Class Container.
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class Container extends ContainerBuilder
{
    /**
     * @throws \Exception
     */
    public static function buildContainer($rootPath): Container
    {
        $container = new self();

        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);

        $container->addCompilerPass(new RouterTagCompilerPass());

        $container->setProxyInstantiator(new RuntimeInstantiator());

        $container->setParameter('app_root', $rootPath);

        $defaultLoader = new DefaultYamlFileLoader($container, new FileLocator($rootPath.'/config'));
        $defaultLoader->load('services.yml');

        $container->compile();

        return $container;
    }

    /**
     * @param string $id
     * @param int    $invalidBehavior
     *
     * @throws \Exception
     */
    public function get($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): ?object
    {
        if ('service_container' === strtolower($id)) {
            if (ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE !== $invalidBehavior) {
                return null;
            }
            throw new InvalidArgumentException(sprintf('The service definition "%s" does not exist.', $id));
        }

        return parent::get($id, $invalidBehavior);
    }
}
