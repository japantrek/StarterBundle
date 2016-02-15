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
        // get all Bundles
        $bundles = $container->getParameter('kernel.bundles');

        $this->prependCmfRoutingBundle($container, $bundles);
        $this->prependCmfContentBundle($container, $bundles);
        $this->prependCmfMenuBundle($container, $bundles);
        $this->prependSonataBlockBundle($container, $bundles);
        $this->prependFMElfinderBundle($container, $bundles);
        $this->prependLiipImagineBundle($container, $bundles);
        $this->SonataAdminBundle($container, $bundles);

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

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependCmfRoutingBundle(ContainerBuilder $container, $bundles)
    {
        if (isset($bundles['CmfRoutingBundle'])) {
            $config = array(
                'chain' => array(
                    'routers_by_id' => array(
                        'cmf_routing.dynamic_router' => 20,
                        'router.default' => 100
                    )
                ),
                'dynamic' => array(
                    /*
                    'templates_by_class' => array(
                        'nvbooster\StarterBundle\Document\SeoContent' => '@NvboosterStarter/seocontent.html.twig',
                        'nvbooster\StarterBundle\Document\OnePageContent' => '@NvboosterStarter/opcontent.html.twig',
                        'nvbooster\StarterBundle\Document\OnePageSection' => '@NvboosterStarter/opsection_standalone.html.twig'
                    ),*/
                    'controllers_by_class' => array(
                        'Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\RedirectRoute' => 'cmf_routing.redirect_controller:redirectAction',
                        'nvbooster\StarterBundle\Document\OnePageContent' => 'cmf_content.controller:indexAction'
                    )
                )
            );

            $container->prependExtensionConfig('cmf_routing', $config);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependCmfContentBundle(ContainerBuilder $container, $bundles)
    {
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
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependCmfMenuBundle(ContainerBuilder $container, $bundles)
    {
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
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependSonataBlockBundle(ContainerBuilder $container, $bundles)
    {
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
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependFMElfinderBundle(ContainerBuilder $container, $bundles)
    {
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
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function prependLiipImagineBundle(ContainerBuilder $container, $bundles)
    {
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
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    public function SonataAdminBundle(ContainerBuilder $container, $bundles)
    {
        if (isset($bundles['SonataAdminBundle'])) {
            $this->prependConfigYml($container, 'sonata_admin.yml');
        }

        if (isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            $this->prependConfigYml($container, 'sonata_doctrine_phpcr_admin.yml');
        }
    }

    public function prependConfigYml(ContainerBuilder $container, $configFileName)
    {
        if (!class_exists('Symfony\Component\Yaml\Parser')) {
            throw new RuntimeException('Unable to load YAML config files as the Symfony Yaml Component is not installed.');
        }

        $locator = new FileLocator(__DIR__.'/../Resources/config');
        $yamlParser = new YamlParser();

        $file = $locator->locate($configFileName);

        if (!stream_is_local($file)) {
            throw new InvalidArgumentException(sprintf('This is not a local file "%s".', $file));
        }

        if (!file_exists($file)) {
            throw new InvalidArgumentException(sprintf('The service file "%s" is not valid.', $file));
        }

        try {
            $config = $yamlParser->parse(file_get_contents($file));
        } catch (ParseException $e) {
            throw new InvalidArgumentException(sprintf('The file "%s" does not contain valid YAML.', $file), 0, $e);
        }

        // empty file
        if (null !== $config) {
            if (!is_array($config)) {
                throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $configFileName));
            } else {
                foreach (array_keys($config) as $key) {
                    $container->prependExtensionConfig($key, $config[$key]);
                }
            }
        }
    }
}
