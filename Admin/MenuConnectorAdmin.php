<?php
namespace nvbooster\StarterBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use nvbooster\StarterBundle\Document\OnePageSection;
use Sonata\DoctrinePHPCRAdminBundle\Form\Type\TreeModelType;

/**
 * MenuConnectorAdmin
 *
 * @author nvb <nvb@aproxima.ru>
 */
class MenuConnectorAdmin extends Admin
{
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $translationDomain = 'nvstarter';

    /**
     * @var string
     */
    protected $menuRoot;

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->add('name', 'text');
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureFormFields()
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
            ->add('parentDocument', TreeModelType::class, array('choice_list' => array(), 'root_node' => $this->getRootPath()))
            ->add('name', 'text')
            ->add('label', 'text', array('required' => false))
            ->add('connectedNode', TreeModelType::class, array('choice_list' => array(), 'required' => false, 'select_root_node' => false, 'root_node' => $this->menuRoot))
        ->end();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('node', 'doctrine_phpcr_nodename')
            ->add('label', 'doctrine_phpcr_string');
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::getExportFormats()
     */
    public function getExportFormats()
    {
        return array();
    }

    /**
     * @param string $menuRoot
     */
    public function setMenuRoot($menuRoot)
    {
        $this->menuRoot = $menuRoot;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\DoctrinePHPCRAdminBundle\Admin\Admin::toString()
     */
    public function toString($object)
    {
        return $object instanceof OnePageSection && $object->getTitle()
        ? $object->getTitle()
        : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}