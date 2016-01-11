<?php
namespace nvbooster\StarterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompilerPass implements CompilerPassInterface
{
    /**
     * Set fixed templates
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['CmfBlockBundle'])) {
            $blockLoader = $container->getDefinition('cmf.block.container');
            $blockLoader->replaceArgument(3, '@NvboosterStarter/block_container.html.twig');
            $blockLoader = $container->getDefinition('cmf.block.slideshow');
            $blockLoader->replaceArgument(3, '@NvboosterStarter/block_slideshow.html.twig');
        }
    }
}