<?php

namespace nvbooster\StarterBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;
use nvbooster\StarterBundle\Twig\Helper\UrlHelper;

/**
 *
 * @author nvb <nvb@aproxima.ru>
 */
class ExternalUrlExtension extends Twig_Extension
{
    /**
     * @var UrlHelper
     */
    protected $helper;

    /**
     * @param UrlHelper $helper
     */
    public function __construct(UrlHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('external',
                array($this->helper, 'externalUrl'),
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'externalurl_extension';
    }
}
