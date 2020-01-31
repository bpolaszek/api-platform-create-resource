<?php

namespace BenTools\ApiPlatform\CreateResource\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as BaseExtension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class Extension extends BaseExtension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator([__DIR__ . '/../Resources/config/']));
        $loader->load('services.xml');
        $container->setParameter('api_platform.create_resource.allowed_classes', $config['allowed_classes']);
    }

    public function getAlias()
    {
        return 'api_platform_create_resource';
    }
}
