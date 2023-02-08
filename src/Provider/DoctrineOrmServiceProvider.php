<?php

declare(strict_types=1);

namespace Xylene\Provider;

use Doctrine\DBAL\Configuration;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Xylene\Provider\Contract\ServiceProviderInterface;

/**
 * Class DoctrineOrmServiceProvider
 *
 * @package Xylene\Provider
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class DoctrineOrmServiceProvider implements ServiceProviderInterface
{
    /** {@inheritDoc} */
    public function register(ContainerInterface $container): void
    {
        if ($container instanceof Container) {
            throw new \InvalidArgumentException('Invalid Container type argument.');
        }

        /*** @var  Container $container */
        foreach ($this->defaults($container) as $key => $value) {
            if (!$container->hasParameter($key)) {
                $container->setParameter($key, $value);
            }
        }

        //$container->set('app.doctrine.entity_manager', Configuration::class);

        /**
         * Short-cut to getting DoctrineORM Entities functional
         */
        $container->set('app.doctrine.entity_manager', (function() use($container) {

            $paths = $container->getParameter('app.doctrine.orm.entity_path');
            $isDevMode = $container->getParameter('app.doctrine.orm.dev_mode');

            $dbParams = $container->getParameter('app.doctrine.orm.db_params');

            $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
            $connection = DriverManager::getConnection($dbParams, $config);

            return new EntityManager($connection, $config);
        })());
    }

    /**
     * @param $container
     * @return array
     */
    protected function defaults($container): array
    {
        return [
            'orm.doctrine.proxies_dir' => $container->getParameter('app.doctrine.orm.proxies_dir'),
            'orm.doctrine.proxies_namespace' => $container->getParameter('app.doctrine.orm.proxies_namespace'),
            'orm.doctrine.auto_generate_proxies' => $container->getParameter('app.doctrine.orm.auto_generate_proxies'),
            'orm.doctrine.default_cache' => [
                'driver' => $container->getParameter('app.doctrine.orm.default_cache'),
            ],
            'orm.doctrine.custom.functions.string' => [],
            'orm.doctrine.custom.functions.numeric' => [],
            'orm.doctrine.custom.functions.datetime' => [],
            'orm.doctrine.custom.hydration_modes' => [],
            'orm.doctrine.class_metadata_factory_name' => 'Doctrine\ORM\Mapping\ClassMetadataFactory',
            'orm.doctrine.default_repository_class' => 'Doctrine\ORM\EntityRepository',
        ];
    }
}