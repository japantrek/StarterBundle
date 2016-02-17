<?php

namespace nvbooster\StarterBundle\Document;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuOptionsInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNodeReferrersInterface;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNodeBase;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContentBase;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\Doctrine\Phpcr\SeoMetadata;
use Symfony\Cmf\Component\Routing\RouteReferrersInterface;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\NodeInterface;

/**
 * OnePageContent
 *
 * Страница с несколькими секциями и внутренней навигацией
 *
 * @author nvb <nvb@aproxima.ru>
 */
class OnePageContent extends OnePageItem
{

    /**
     * MenuNode[]
     */
    protected $menuNodes;

    /**
     * @var ChildrenCollection
     */
    protected $children;

    /**
     * HTML attributes to add to the children list element.
     *
     * e.g. array('class' => 'foobar', 'style' => 'bar: foo')
     *
     * @var array
     */
    protected $childrenAttributes = array();

    /**
     * __construct
     */
    public function __construct()
    {
        $this->menuNodes = new ArrayCollection();
        $this->children = new ArrayCollection();

        parent::__construct();
    }

    /**
     * Return the children attributes
     *
     * @return array
     */
    public function getChildrenAttributes()
    {
        return $this->childrenAttributes;
    }

    /**
     * Set the children attributes
     *
     * @param array $attributes
     *
     * @return self
     */
    public function setChildrenAttributes(array $attributes)
    {
        $this->childrenAttributes = $attributes;

        return $this;
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
     * Get children
     * @param boolean $all
     *
     * @return ArrayCollection|ChildrenCollection
     */
    public function getChildren($all = false)
    {
        if ($all) {
            $children = $this->children;
        } else {
            $children = array();

            if ($this->getLabel()) {
                $home = new MenuNodeBase($this->name . '_home');
                $home
                    ->setLabel($this->getLabel())
                    ->setAttributes($this->getAttributes())
                    ->setLinkAttributes($this->getLinkAttributes())
                    ->setUri('#' . $this->name);

                $children[] = $home;
            }

            foreach ($this->children as $child) {
                if (($child instanceof OnePageSection) ||
                    ($child instanceof NodeInterface)) {
                    $children[] = $child;
                }
            }
        }

        return $children;
    }

    /**
     * @return integer
     */
    public function hasChildren()
    {
        return (bool) $this->children->count();
    }

    /**
     * Whether to display the child menu items of this page.
     *
     * @return boolean
     */
    public function getDisplayChildren()
    {
        return true;
    }

    /**
     * @param boolean $dummy
     *
     * @return self
     */
    public function setDisplayChildren($dummy)
    {
        return $this;
    }

    /**
     * Get section children
     *
     * @return ArrayCollection|ChildrenCollection
     */
    public function getSectionChildren()
    {
        $children = array();

        foreach ($this->children as $child) {
            if ($child instanceof OnePageSection) {
                $children[] = $child;
            }
        }

        return $children;
    }
}
