<?php

namespace nvbooster\StarterBundle\Block;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author nvb <nvb@aproxima.ru>
 */
trait BlockServiceTrait
{
    /**
     * @var string
     */
    protected $prefix = 'attr-';

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        list(,$block) = func_get_args();
        parent::configureSettings($resolver, $block);

        if ($block) {
            $resolver->setDefaults(
                array_fill_keys(
                    array_filter(
                        array_keys($block->getSettings()),
                        function ($a) {
                            return 0 === strpos($a, $this->prefix);
                        }
                    ),
                    null
                )
            );
        }
    }

    /**
     * @param string $attrPrefix
     */
    public function setAttributesPrefix($attrPrefix)
    {
        $this->prefix = $attrPrefix;
    }
}