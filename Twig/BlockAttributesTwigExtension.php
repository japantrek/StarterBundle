<?php

namespace nvbooster\StarterBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Sonata\BlockBundle\Model\BlockInterface;

/**
 * Генератор HTML атрибутов блока
 * атрибуты в настройках хранятся префиксом attr-
 *
 * @author nvb <nvb@aproxima.ru>
 */
class BlockAttributesTwigExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('sonata_block_attr',
                array($this, 'renderAttributes'),
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * @param BlockInterface $block
     * @param array          $attributes
     * @param string         $prefix
     *
     * @return string
     */
    public function renderAttributes(BlockInterface $block = null, $attributes = array(), $prefix = 'attr')
    {
        if ($attributes && is_string($attributes)) {
            $prefix = $attributes;
            $attributes = array();
        }

        if ($block) {
            foreach ($block->getSettings() as $key => $value) {
                $key = trim(mb_strtolower($key, 'utf8'));
                $match = null;

                if (preg_match('@^' . preg_quote($prefix) . '-([a-z][-a-z0-9]*)$@', $key, $match)) {
                    $attributes[$match[1]] = $value;
                }
            }
        }

        $attributesString = '';
        foreach ($attributes as $key => $value) {
            $key = trim(mb_strtolower($key, 'utf8'));

            if (preg_match('@^[a-z][-a-z0-9]*$@', $key)) {
                $attributesString .= $key . '="' . addslashes($value) . '" ';
            }
        }

        return trim($attributesString);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'blockattributes_extension';
    }
}
