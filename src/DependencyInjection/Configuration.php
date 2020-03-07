<?php

namespace BenTools\ApiPlatform\CreateResource\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        if (\method_exists(TreeBuilder::class, 'root')) {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('api_platform_create_resource');
        } else {
            $treeBuilder = new TreeBuilder('api_platform_create_resource');
            $rootNode = $treeBuilder->getRootNode();
        }
        $rootNode
            ->children()
                ->arrayNode('allowed_classes')
                ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
