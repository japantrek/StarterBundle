<?php
namespace nvbooster\StarterBundle\Twig\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class UrlHelper
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function externalUrl($content)
    {
        $router = $this->container->get('router');

        $content = preg_replace_callback(
            '@href="(\w+:\/\/[^"]+)"@',
            function ($matches) use ($router) {
                return 'rel="nofollow" href="' . $router->generate('nvbooster_starter.external_link', array('go' => $matches[1])) . '"';
            }, $content
        );

        return $content;
    }
}