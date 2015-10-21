<?php
namespace nvbooster\StarterBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use nvbooster\StarterBundle\Document\UnitBlock;

/**
 * UnitBlockAdmin
 *
 * @author nvb <nvb@aproxima.ru>
 */
class UnitBlockAdmin extends Admin
{
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $translationDomain = 'TPWebBundle';

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->addIdentifier('name', 'text');
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
                ->add('parentDocument', 'doctrine_phpcr_odm_tree', array('choice_list' => array(), 'root_node' => $this->getRootPath()))
                ->add('name', 'text')
                ->add('title', 'text', array('required' => false))
                ->add('image', 'text', array('required' => false))
                ->add('route', 'text', array('required' => false))
                ->add('url', 'url', array('required' => false))
                ->add('text', 'textarea')
            ->end();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', 'doctrine_phpcr_string');
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
     * {@inheritDoc}
     *
     * @see \Sonata\DoctrinePHPCRAdminBundle\Admin\Admin::toString()
     */
    public function toString($object)
    {
        return $object instanceof UnitBlock && $object->getName()
        ? $object->getName()
        : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}