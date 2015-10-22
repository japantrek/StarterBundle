<?php

namespace nvbooster\StarterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;

/**
 * NvboosterStarterBundle
 *
 * @author nvb <nvb@aproxima.ru>
 */
class NvboosterStarterBundle extends Bundle
{
    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::build()
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
                    array(
                        realpath(__DIR__ . '/Resources/config/doctrine-phpcr') => 'nvbooster\StarterBundle\Document',
                    ),
                    array('cmf_core.persistence.phpcr.manager_name'),
                    false,
                    array('NvboosterStarterBundle' => 'nvbooster\StarterBundle\Document')
                    )
                );
        }
    }
}
