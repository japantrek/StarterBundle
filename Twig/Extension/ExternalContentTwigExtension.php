<?php

namespace nvbooster\StarterBundle\Twig\Extension;

use HTMLPurifier;
use Twig_Extension;
use Twig_SimpleFilter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Преобразование текста из внешних источников
 *
 * @author nvb <nvb@aproxima.ru>
 */
class ExternalContentTwigExtension extends Twig_Extension
{
    /**
     * @var HTMLPurifier $purifier
     */
    private $purifier;
    private $urlRewrite;

    private $container;

    /**
     * @param ContainerInterface $container
     * @param boolean            $urlRewrite
     */
    public function __construct(ContainerInterface $container, $urlRewrite = false)
    {
        $this->container = $container;
        $this->urlRewrite = $urlRewrite;
    }

    /**
     * @return HTMLPurifier
     */
    private function initialize()
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', '*[style|title],div,span,blockquote,code,pre,p,b,i,strong,br,ul,ol,li,dd,dt,dl,sup,sub,a[href],img[src|width|height|alt]');
        $config->set('HTML.Nofollow', true);
        if ($this->urlRewrite) {
            $config->set('URI.Munge', $this->container->get('router')->generate('nvbooster_starter.external_link', array('go' => '')) . '%s');
        }
        $this->purifier = new \HTMLPurifier($config);

        return $this->purifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('external_content',
                array($this, 'convertExternalContent'),
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * @param string $html
     *
     * @return string
     */
    public function convertExternalContent($html)
    {
        if (!$this->purifier) {
            $this->initialize();
        }

        return $this->purifier->purify($html);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'externalcontent_extension';
    }
}
