<?php

namespace nvbooster\StarterBundle\Document;

use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\AbstractBlock;

/**
 * UnitBlock
 *
 * Блок данных с привязанным изображением
 *
 * @author nvb <nvb@aproxima.ru>
 */
class UnitBlock extends AbstractBlock
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $image;

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\BlockBundle\Model\BlockInterface::getType()
     */
    public function getType()
    {
        return 'nvbooster_starter.block.unit';
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $url
     */
    public function setImage($url)
    {
        $this->image = $url;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }
}