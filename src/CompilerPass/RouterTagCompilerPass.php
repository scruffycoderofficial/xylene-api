<?php

declare(strict_types=1);

namespace Xylene\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RouterTagCompilerPass.
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class RouterTagCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $routeTags = $container->findTaggedServiceIds('route');

        $collectionTags = $container->findTaggedServiceIds('route_collection');

        /** @var Definition[] $routeCollections */
        $routeCollections = [];
        foreach ($collectionTags as $serviceName => $tagData) {
            $routeCollections[] = $container->getDefinition($serviceName);
        }

        foreach ($routeTags as $routeServiceName => $tagData) {
            $routeNames = [];
            foreach ($tagData as $tag) {
                if (isset($tag['route_name'])) {
                    $routeNames[] = $tag['route_name'];
                }
            }

            if (!$routeNames) {
                continue;
            }

            $routeReference = new Reference($routeServiceName);
            foreach ($routeCollections as $collection) {
                foreach ($routeNames as $name) {
                    $collection->addMethodCall('add', [$name, $routeReference]);
                }
            }
        }
    }
}