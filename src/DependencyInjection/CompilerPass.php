<?php

namespace BenTools\ApiPlatform\CreateResource\DependencyInjection;

use BenTools\ApiPlatform\CreateResource\DataProvider\CreatableIdentifierDataProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition(CreatableIdentifierDataProvider::class);
        foreach ($container->getParameter('api_platform.create_resource.allowed_classes') as $className => $factory) {
            $definition->addMethodCall('registerClass', [$className, null !== $factory ? new Reference(\ltrim($factory, '@')) : null]);
        }
    }
}
