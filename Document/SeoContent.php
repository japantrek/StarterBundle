<?php

namespace nvbooster\StarterBundle\Document;

use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\Doctrine\Phpcr\SeoMetadata;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContentBase;
use Symfony\Cmf\Component\Routing\RouteReferrersInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNodeReferrersInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;
use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\NodeInterface;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Cmf\Bundle\SeoBundle\Extractor\OriginalRouteReadInterface;
use nvbooster\StarterBundle\Sitemap\SitemapPropertiesInterface;

/**
 * SeoContent
 *
 * Страница с SEO данными
 *
 * @author nvb <nvb@aproxima.ru>
 */
class SeoContent extends StaticContentBase implements
    RouteReferrersInterface,
    MenuNodeReferrersInterface,
    PublishTimePeriodInterface,
    PublishableInterface,
    SeoAwareInterface,
    OriginalRouteReadInterface,
    SitemapPropertiesInterface,
    TranslatableInterface
{
    /**
     * @var SeoMetadata
     *
     */
    protected $seoMetadata;

    /**
     * @var BlockInterface additionalInfoBlock
     *
     */
    protected $additionalInfoBlock;

    /**
     * @var boolean whether this content is publishable
     */
    protected $publishable = true;

    /**
     * @var \DateTime|null publication start time
     */
    protected $publishStartDate;

    /**
     * @var \DateTime|null publication end time
     */
    protected $publishEndDate;

    /**
     * @var RouteObjectInterface[]
     */
    protected $routes;

    /**
     * @var MenuNode[]
     */
    protected $menuNodes;

    /**
     * PHPCR node
     *
     * @var NodeInterface
     */
    protected $sideMenu;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var double
     */
    protected $pageWeight;

    /**
     * @var string
     */
    protected $updatePeriod;

    /**
     * @var boolean
     */
    protected $visibleInSitemap;

    /**
     * @var string
     */
    protected $locale;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->seoMetadata = new SeoMetadata();
        $this->routes = new ArrayCollection();
        $this->menuNodes = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function getSeoMetadata()
    {
        return $this->seoMetadata;
    }

    /**
     * {@inheritDoc}
     */
    public function setSeoMetadata($seoMetadata)
    {
        $this->seoMetadata = $seoMetadata;
    }


    /**
     * {@inheritDoc}
     */
    public function setPublishable($publishable)
    {
        return $this->publishable = (bool) $publishable;
    }

    /**
     * {@inheritDoc}
     */
    public function isPublishable()
    {
        return $this->publishable;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * {@inheritDoc}
     */
    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    /**
     * {@inheritDoc}
     */
    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;
    }


    /**
     * {@inheritDoc}
     */
    public function addRoute($route)
    {
        $this->routes->add($route);
    }

    /**
     * {@inheritDoc}
     */
    public function removeRoute($route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * {@inheritDoc}
     */
    public function addMenuNode(NodeInterface $menu)
    {
        $this->menuNodes->add($menu);
    }

    /**
     * {@inheritDoc}
     */
    public function removeMenuNode(NodeInterface $menu)
    {
        $this->menuNodes->removeElement($menu);
    }

    /**
     * {@inheritDoc}
     */
    public function getMenuNodes()
    {
        return $this->menuNodes;
    }

    /**
     * @return NodeInterface
     */
    public function getSideMenu()
    {
        return $this->sideMenu;
    }

    /**
     * @param string $sideMenu
     *
     * @return SeoContent
     */
    public function setSideMenu(NodeInterface $sideMenu)
    {
        $this->sideMenu = $sideMenu;

        return $this;
    }

    /**
     * @return BlockInterface
     */
    public function getAdditionalInfoBlock()
    {
        return $this->additionalInfoBlock;
    }

    /**
     * Set the additional info block for this content. Usually you want this to
     * be a container block in order to be able to add several blocks.
     *
     * @param BlockInterface $block must be persistable through cascade by the
     *                              persistence layer.
     */
    public function setAdditionalInfoBlock(BlockInterface $block = null)
    {
        $this->additionalInfoBlock = $block;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return SeoContent
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Bundle\SeoBundle\Extractor\OriginalRouteReadInterface::getSeoOriginalRoute()
     */
    public function getSeoOriginalRoute()
    {
        list($route) = $this->routes;

        return $route ? $route->getId() : false;
    }

    /**
     * {@inheritdoc}
     * @see \nvbooster\StarterBundle\Sitemap\SitemapPropertiesReadInterface::getPageWeight()
     */
    public function getPageWeight()
    {
        return $this->pageWeight;
    }

    /**
     * {@inheritdoc}
     * @see \nvbooster\StarterBundle\Sitemap\SitemapPropertiesInterface::setPageWeight()
     */
    public function setPageWeight($weight)
    {
        $this->pageWeight = $weight;
    }

    /**
     * {@inheritdoc}
     * @see \nvbooster\StarterBundle\Sitemap\SitemapPropertiesReadInterface::getUpdatePeriod()
     */
    public function getUpdatePeriod()
    {
        return $this->updatePeriod;
    }

    /**
     * {@inheritdoc}
     * @see \nvbooster\StarterBundle\Sitemap\SitemapPropertiesInterface::setUpdatePeriod()
     */
    public function setUpdatePeriod($period)
    {
        $this->updatePeriod = $period;
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Bundle\SeoBundle\SitemapAwareInterface::isVisibleInSitemap()
     */
    public function getVisibleInSitemap()
    {
        return $this->visibleInSitemap;
    }

    /**
     * {@inheritdoc}
     * @see \Symfony\Cmf\Bundle\SeoBundle\SitemapAwareInterface::isVisibleInSitemap()
     */
    public function isVisibleInSitemap($sitemap)
    {
        return (bool) $this->getVisibleInSitemap();
    }

    /**
     * {@inheritdoc}
     * @see \nvbooster\StarterBundle\Sitemap\SitemapPropertiesInterface::setVisibleInSitemap()
     */
    public function setVisibleInSitemap($visible)
    {
        $this->visibleInSitemap = $visible;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
