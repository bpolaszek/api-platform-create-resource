<?php

namespace BenTools\ApiPlatform\CreateResource;

use BenTools\ApiPlatform\CreateResource\DependencyInjection\CompilerPass;
use BenTools\ApiPlatform\CreateResource\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ApiPlatformCreateResourceBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new Extension();
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CompilerPass());
    }
}
