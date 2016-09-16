<?php
namespace nvbooster\StarterBundle\Document;

use Knp\Menu\NodeInterface;
use Doctrine\ODM\PHPCR\HierarchyInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuOptionsInterface;
use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class MenuConnector implements
    NodeInterface,
    HierarchyInterface,
    MenuOptionsInterface,
    TranslatableInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * PHPCR parent document
     *
     * @var string
     */
    protected $parent;

    /**
     * PHPCR document name
     *
     * @var string
     */
    protected $name;

    /**
     * PHPCR node
     *
     * @var NodeInterface
     */
    protected $node;

    /**
     * @var string
     */
    protected $label;

    /**
     * HTML attributes to add to the individual menu element.
     *
     * e.g. array('class' => 'foobar', 'style' => 'bar: foo')
     *
     * @var array
     */
    protected $attributes = array();

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
     * HTML attributes to add to the children elements.
     *
     * @var array
     */
    protected $childrenAttributes = array();

    /**
     * Set to false to not render a menu item for this.
     *
     * @var boolean
     */
    protected $display = true;

    /**
     * @var boolean
     */
    protected $displayChildren = true;

    /**
     * @var NodeInterface
     */
    protected $connectedNode;

    /**
     * @var string
     */
    protected $locale;

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setParentDocument($parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritDoc}
     */
    public function getParentDocument()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the underlying PHPCR node of this document
     *
     * @return NodeInterface
     */
    public function getNode()
    {
        return $this->node;
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
     * @param array $childrenAttributes
     *
     * @return self
     */
    public function setChildrenAttributes(array $childrenAttributes)
    {
        $this->childrenAttributes = $childrenAttributes;

        return $this;
    }

    /**
     * @param string $name
     * @param string $default
     *
     * @return mixed|string
     */
    public function getChildrenAttribute($name, $default = null)
    {
        if (isset($this->childrenAttributes[$name])) {
            return $this->childrenAttributes[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return MenuConnector
     */
    public function setChildrenAttribute($name, $value)
    {
        $this->childrenAttributes[$name] = $value;

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
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
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
        return $this->displayChildren;
    }

    /**
     * @param boolean $displayChildren
     *
     * @return MenuConnector
     */
    public function setDisplayChildren($displayChildren)
    {
        $this->displayChildren = $displayChildren;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        $connectedOption = $this->connectedNode->getOptions();

        return array(
            'label' => $this->getLabel() ?: $connectedOption['label'],
            'attributes' => array_merge($connectedOption['attributes'], $this->getAttributes()),
            'childrenAttributes' => array_merge($connectedOption['childrenAttributes'], $this->getChildrenAttributes()),
            'display' => $this->getDisplay() && $connectedOption['display'],
            'displayChildren' => $this->getDisplayChildren() && $connectedOption['displayChildren'],
            'linkAttributes' => array_merge($connectedOption['linkAttributes'], $this->getLinkAttributes()),
            'labelAttributes' => array_merge($connectedOption['labelAttributes'], $this->getLabelAttributes()),
            'uri' => $connectedOption['uri'],
            'route' => $connectedOption['route'],
            'linkType' => $connectedOption['linkType'],
            'content' => $connectedOption['content']
        );
    }

    /**
     * Get children
     *
     * @return ArrayCollection|ChildrenCollection
     */
    public function getChildren()
    {
        return $this->connectedNode->getChildren();
    }

    /**
     * @param NodeInterface $connectedNode
     *
     * @return MenuConnector
     */
    public function setConnectedNode(NodeInterface $connectedNode)
    {
        $this->connectedNode = $connectedNode;

        return $this;
    }

    /**
     * @return NodeInterface
     */
    public function getConnectedNode()
    {
        return $this->connectedNode;
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