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
            $prefix = $container->getParameter('nvbooster_starter.block.attribute.prefix');
            $blockLoader = $container->getDefinition('cmf.block.container');
            $blockLoader->setClass('nvbooster\StarterBundle\Block\ContainerBlockService');
            $blockLoader->addMethodCall('setAttributesPrefix', array($prefix));
            if (
                $container->hasParameter('nvbooster_starter.template.containerblock') &&
                $template = $container->getParameter('nvbooster_starter.template.containerblock')
            ) {
                $blockLoader->replaceArgument(3, $template);
            }

            $blockLoader = $container->getDefinition('cmf.block.string');
            $blockLoader->setClass('nvbooster\StarterBundle\Block\StringBlockService');
            $blockLoader->addMethodCall('setAttributesPrefix', array($prefix));

            $blockLoader = $container->getDefinition('cmf.block.simple');
            $blockLoader->setClass('nvbooster\StarterBundle\Block\SimpleBlockService');
            $blockLoader->addMethodCall('setAttributesPrefix', array($prefix));

            $blockLoader = $container->getDefinition('cmf.block.action');
            $blockLoader->setClass('nvbooster\StarterBundle\Block\ActionBlockService');
            $blockLoader->addMethodCall('setAttributesPrefix', array($prefix));
        }

        if ($def = $container->getDefinition('cmf_seo.presentation')) {
            $def->replaceArgument(3, null);
        }
    }
}
