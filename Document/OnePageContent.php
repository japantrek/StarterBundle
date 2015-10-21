<?php

namespace nvbooster\StarterBundle\Document;

use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\Doctrine\Phpcr\SeoMetadata;
use Knp\Menu\NodeInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuOptionsInterface;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContentBase;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNodeReferrersInterface;
use Symfony\Cmf\Component\Routing\RouteReferrersInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNodeBase;

/**
 * OnePageContent
 *
 * Страница с несколькими секциями и внутренней навигацией
 *
 * @author nvb <nvb@aproxima.ru>
 */
class OnePageContent extends StaticContentBase implements
    SeoAwareInterface,
    MenuNodeReferrersInterface,
    RouteReferrersInterface,
    PublishTimePeriodInterface,
    PublishableInterface,
    NodeInterface,
    MenuOptionsInterface
{

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
     * MenuNode[]
     */
    protected $menuNodes;

    /**
     * Hashmap for application data associated to this document. Both keys and
     * values must be strings.
    */
    protected $extras = array();

    /**
     * @var SeoMetadata
     *
     */
    protected $seoMetadata;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var ChildrenCollection
     */
    protected $children;

    /**
     * HTML attributes to add to the individual menu element.
     *
     * e.g. array('class' => 'foobar', 'style' => 'bar: foo')
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * HTML attributes to add to the children list element.
     *
     * e.g. array('class' => 'foobar', 'style' => 'bar: foo')
     *
     * @var array
     */
    protected $childrenAttributes = array();

    /**
     * HTML attributes to add to items link.
     *
     * e.g. array('class' => 'foobar', 'style' => 'bar: foo')
     *
     * @var array
     */
    protected $linkAttributes = array();

    /**
     * HTML attributes to add to the items label.
     *
     * e.g. array('class' => 'foobar', 'style' => 'bar: foo')
     *
     * @var array
     */
    protected $labelAttributes = array();

    /**
     * Set to false to not render a menu item for this.
     *
     * @var boolean
     */
    protected $display = true;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->seoMetadata = new SeoMetadata();
        $this->routes = new ArrayCollection();
        $this->menuNodes = new ArrayCollection();
        $this->children = new ArrayCollection();
    }


    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContentBase::setName()
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContentBase::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the attributes associated with this menu node
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes associated with this menu node
     *
     * @param array $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Return the given attribute, optionally specifying a default value
     *
     * @param string $name    The name of the attribute to return
     * @param string $default The value to return if the attribute doesn't exist
     *
     * @return string
     */
    public function getAttribute($name, $default = null)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return $default;
    }

    /**
     * Set the named attribute
     *
     * @param string $name  attribute name
     * @param string $value attribute value
     *
     * @return self
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
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
     * Get the link HTML attributes.
     *
     * @return array
     */
    public function getLinkAttributes()
    {
        return $this->linkAttributes;
    }

    /**
     * Set the link HTML attributes as associative array.
     *
     * @param array $linkAttributes
     *
     * @return self
     */
    public function setLinkAttributes($linkAttributes)
    {
        $this->linkAttributes = $linkAttributes;

        return $this;
    }

    /**
     * Get the label HTML attributes.
     *
     * @return array
     */
    public function getLabelAttributes()
    {
        return $this->labelAttributes;
    }

    /**
     * Set the label HTML attributes as associative array.
     *
     * @param array $labelAttributes
     *
     * @return self
     */
    public function setLabelAttributes($labelAttributes)
    {
        $this->labelAttributes = $labelAttributes;

        return $this;
    }

    /**
     * Whether a menu item for this page should be displayed if possible.
     *
     * @return boolean
     *
     * @see isDisplayableMenu
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set whether to display the menu item for this.
     *
     * @param boolean $display
     *
     * @return self
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
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
     * Set whether to display the child menu items of this page.
     *
     * @param boolean $displayChildren
     *
     * @return self
     */
    public function setDisplayChildren($displayChildren)
    {
        return $this;
    }

    /**
     * Whether this page can be displayed in the menu, meaning getDisplay is
     * true and there is a non-empty label.
     *
     * @return boolean
     */
    public function isDisplayableMenu()
    {
        return $this->getDisplay() && $this->getLabel();
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        return array(
            'label' => $this->getLabel(),
            'attributes' => $this->getAttributes(),
            'childrenAttributes' => $this->getChildrenAttributes(),
            'display' => $this->isDisplayableMenu(),
            'displayChildren' => $this->getDisplayChildren(),
            'linkAttributes' => $this->getLinkAttributes(),
            'labelAttributes' => $this->getLabelAttributes(),
        );
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
     * Get the application information associated with this document
     *
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Get a single application information value
     *
     * @param string      $name
     * @param string|null $default
     *
     * @return string|null the value at $name if set, null otherwise
     */
    public function getExtra($name, $default = null)
    {
        return isset($this->extras[$name]) ? $this->extras[$name] : $default;
    }

    /**
     * Set the application information
     *
     * @param array $extras
     *
     * @return StaticContent - this instance
     */
    public function setExtras(array $extras)
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Set a single application information value.
     *
     * @param string $name  name
     * @param string $value the new value, null removes the entry
     *
     * @return StaticContent
     */
    public function setExtra($name, $value)
    {
        if (is_null($value)) {
            unset($this->extras[$name]);
        } else {
            $this->extras[$name] = $value;
        }

        return $this;
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
                $home = new MenuNodeBase($this->getName() . '_home');
                $home
                    ->setLabel($this->getLabel())
                    ->setAttributes($this->getAttributes())
                    ->setLinkAttributes($this->getLinkAttributes())
                    ->setUri('#' . $this->getName());

                $children[] = $home;
            }

            foreach ($this->children as $child) {
                if (($child instanceof OnePageSection) ||
                    ($child instanceof MenuNode)) {
                    $children[] = $child;
                }
            }
        }

        return $children;
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

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
