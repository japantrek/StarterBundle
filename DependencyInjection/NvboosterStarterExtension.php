<?php

namespace nvbooster\StarterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NvboosterStarterExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $this->prependCmfRoutingBundle($container, $bundles);
        $this->prependCmfContentBundle($container, $bundles);
        $this->prependCmfMenuBundle($container, $bundles);
        $this->prependSonataBlockBundle($container, $bundles);
    }

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

        if (isset($bundles['CmfCreateBundle'])) {
            $blockLoader = $container->getDefinition('nvbooster_starter.block.unit');
            $blockLoader->addMethodCall('setTemplate', array('NvboosterStarter/unitblock_createphp.html.twig'));
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependCmfRoutingBundle(ContainerBuilder $container, $bundles)
    {
        $config = array(
            'dynamic' => array(
                'templates_by_class' => array(
                    'nvbooster\StarterBundle\Document\SeoContent' => '@NvboosterStarter/seocontent.html.twig',
                    'nvbooster\StarterBundle\Document\OnePageContent' => '@NvboosterStarter/opcontent.html.twig',
                    'nvbooster\StarterBundle\Document\OnePageSection' => '@NvboosterStarter/opsection_standalone.html.twig'
                ),
                'controllers_by_class' => array(
                    'nvbooster\StarterBundle\Document\OnePageContent' => 'cmf_content.controller:indexAction'
                )
            )
        );

        if (isset($bundles['CmfCreateBundle'])) {
            $config['dynamic']['templates_by_class']['nvbooster\StarterBundle\Document\SeoContent'] = '@NvboosterStarter/seocontent_createphp.html.twig';
            $config['dynamic']['templates_by_class']['nvbooster\StarterBundle\Document\OnePageContent'] = '@NvboosterStarter/opcontent_createphp.html.twig';
            $config['dynamic']['templates_by_class']['nvbooster\StarterBundle\Document\OnePageSection'] = '@NvboosterStarter/opsection_standalone.html.twig';
        }

        $container->prependExtensionConfig('cmf_routing', $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependCmfContentBundle(ContainerBuilder $container, $bundles)
    {
        $config = array(
            'persistence' => array(
                'phpcr' => array (
                    'document_class' => 'nvbooster\StarterBundle\Document\SeoContent'
                )
            )
        );

        $container->prependExtensionConfig('cmf_content', $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependCmfMenuBundle(ContainerBuilder $container, $bundles)
    {
        $config = array(
            'admin_extensions' => array(
                'menu_options' => array (
                    'advanced' => true
                )
            )
        );

        $container->prependExtensionConfig('cmf_menu', $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependSonataBlockBundle(ContainerBuilder $container, $bundles)
    {
        $config = array(
            'templates' => array(
                'block_base' => '@NvboosterStarter/block_base.html.twig',
            )
        );

        $container->prependExtensionConfig('sonata_block', $config);
    }
}
