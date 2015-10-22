<?php

namespace nvbooster\StarterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Yaml\Parser as YamlParser;


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
        // get all Bundles
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['CmfRoutingBundle'])) {
            $config = array(
                'chain' => array(
                    'routers_by_id' => array(
                        'cmf_routing.dynamic_router' => 20,
                        'router.default' => 100
                    )
                ),
                'dynamic' => array(
                    'templates_by_class' => array(
                        'nvbooster\StarterBundle\Document\SeoContent' => '@NvboosterStarter/seocontent.html.twig',
                        'nvbooster\StarterBundle\Document\OnePageContent' => '@NvboosterStarter/opcontent.html.twig',
                        'nvbooster\StarterBundle\Document\OnePageSection' => '@NvboosterStarter/opsection_standalone.html.twig'
                    ),
                    'controllers_by_class' => array(
                        'Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\RedirectRoute' => 'cmf_routing.redirect_controller:redirectAction',
                        'nvbooster\StarterBundle\Document\OnePageContent' => 'cmf_content.controller:indexAction'
                    )
                )
            );

            $container->prependExtensionConfig('cmf_routing', $config);
        }

        if (isset($bundles['CmfContentBundle'])) {
            $config = array(
                'persistence' => array(
                    'phpcr' => array (
                        'document_class' => 'nvbooster\StarterBundle\Document\SeoContent'
                    )
                )
            );

            $container->prependExtensionConfig('cmf_content', $config);
        }

        if (isset($bundles['CmfMenuBundle'])) {
            $config = array(
                'admin_extensions' => array(
                    'menu_options' => array (
                        'advanced' => true
                    )
                )
            );

            $container->prependExtensionConfig('cmf_menu', $config);
        }

        if (isset($bundles['SonataBlockBundle'])) {
            $config = array(
                'templates' => array(
                    'block_base' => '@NvboosterStarter/block_base.html.twig',
                ),
                'blocks' => array(
                    'sonata.admin.block.admin_list' => array(
                        'contexts' => array('admin')
                    ),
                    'sonata.admin.block.search_result' => array(
                        'contexts' => array('admin')
                    ),
                    'sonata_admin_doctrine_phpcr.tree_block' => array(
                        'contexts' => array('admin'),
                        'settings' => array(
                            'id' => '/cms'
                        )
                    )
                ),
            );

            $container->prependExtensionConfig('sonata_block', $config);
        }


        if (isset($bundles['FMElfinderBundle'])) {
            $config = array(
                'instances' => array(
                    'default' => array(
                        'editor' => 'ckeditor',
                        'connector' => array(
                            'roots' => array(
                                'media' => array(
                                    'driver' => 'cmf_media.adapter.elfinder.phpcr_driver',
                                    'path' => '%cmf_media.persistence.phpcr.media_basepath%',
                                    'upload_allow' => array('all'),
                                    'upload_max_size' => '2M'
                                )
                            )
                        )

                    )
                )
            );

            $container->prependExtensionConfig('fm_elfinder', $config);
        }

        if (isset($bundles['LiipImagineBundle'])) {
            $config = array(
                'resolvers' => array(
                    'default' => array(
                        'web_path' => null
                    )
                ),
                'filter_sets' => array(
                    'cache' => null,
                    'elfinder_thumbnail' => array(
                        'data_loader' => 'cmf_media_doctrine_phpcr',
                        'quality' => 85,
                        'filters' => array(
                            'thumbnail' => array(
                                'size' => array(48, 48),
                                'mode' => 'inset'
                            )
                        )
                    ),
                    'image_upload_thumbnail' => array(
                        'data_loader' => 'cmf_media_doctrine_phpcr',
                        'quality' => 85,
                        'filters' => array(
                            'thumbnail' => array(
                                'size' => array(100, 100),
                                'mode' => 'outbound'
                            )
                        )

                    )
                )
            );

            $container->prependExtensionConfig('liip_imagine', $config);
        }

        if (isset($bundles['CmfContentBundle'])) {
            $yamlParser = new YamlParser();

            $config = $yamlParser->parse(file_get_contents(__DIR__.'/../Resources/config/sonata_admin.yml'));

            // empty file
            if (null !== $config) {
                if (!is_array($config)) {
                    throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', 'sonata_admin.yml'));
                } else {
                    $container->prependExtensionConfig('sonata_admin', $config['sonata_admin']);
                }
            }
        }
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
        $loader->load('admin.xml');
        $loader->load('twigextensions.xml');
        $loader->load('externallinks.xml');

        if ($whitelist = $container->getParameter('host_whitelist')) {
            if (is_string($whitelist) && $whitelist) {
                $whitelist = array($whitelist);
            }

            if (is_array($whitelist) && count($whitelist)) {
                $container
                    ->getDefinition('nvbooster_starter.externallink')
                    ->replaceArgument(2, $whitelist)
                ;
            }
        }

        if ($config['templates']['externallink']) {
            $container
                ->getDefinition('nvbooster_starter.externallink')
                ->replaceArgument(0, $config['templates']['externallink'])
            ;
        }

        if ($config['wrap_urls']) {
            $container
                ->getDefinition('nvbooster_starter.externalcontent_twigextension')
                ->replaceArgument(1, $config['wrap_urls'])
            ;
        }
    }
}
