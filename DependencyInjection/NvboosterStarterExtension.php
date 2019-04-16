<?php

namespace nvbooster\StarterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NvboosterStarterExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('phpcr.xml');
        $loader->load('cmf.xml');
        $loader->load('twigextensions.xml');

        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load('admin.xml');
        }

        if (isset($bundles['CmfSeoBundle'])) {
            $loader->load('sitemap.xml');
        }

        if ($tpl = $config['templates']['containerblock']) {
            $container->setParameter('nvbooster_starter.template.containerblock', $tpl);
        }
    }
}
