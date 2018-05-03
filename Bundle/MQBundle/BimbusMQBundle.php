<?php

namespace Bimbus\Bundle\MQBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class BimbusMQBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $this->load([], $container);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        // load service
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('services.yml');
    }
}
