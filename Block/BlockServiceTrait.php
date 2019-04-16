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
        parent::configureSettings($resolver);
        $resolver->setDefined(array_map(function ($attr) { return $this->prefix . $attr; }, [
            'id',
            'class',
            'style',
        ]));
    }

    /**
     * @param string $attrPrefix
     */
    public function setAttributesPrefix($attrPrefix)
    {
        $this->prefix = $attrPrefix;
    }
}