<?php
namespace nvbooster\StarterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class CompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     * Set fixed templates
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['CmfBlockBundle'])) {
            if (
                $container->hasParameter('nvbooster_starter.template.containerblock') &&
                $template = $container->getParameter('nvbooster_starter.template.containerblock')
            ) {
                $blockLoader = $container->getDefinition('cmf.block.container');
                $blockLoader->replaceArgument(3, $template);
            }

            if (
                $container->hasParameter('nvbooster_starter.template.slideshowblock') &&
                $template = $container->getParameter('nvbooster_starter.template.slideshowblock')
            ) {
                $blockLoader = $container->getDefinition('cmf.block.slideshow');
                $blockLoader->replaceArgument(3, $template);
            }
        }

        if ($def = $container->getDefinition('cmf_seo.presentation')) {
            $def->replaceArgument(3, null);
        }
    }
}
