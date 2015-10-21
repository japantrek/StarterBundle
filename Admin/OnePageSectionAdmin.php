<?php
namespace nvbooster\StarterBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use nvbooster\StarterBundle\Document\OnePageSection;

/**
 * OnePageSectionAdmin
 *
 * @author nvb <nvb@aproxima.ru>
 */
class OnePageSectionAdmin extends Admin
{
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $translationDomain = 'TPWebBundle';

    /**
     * @var string
     */
    protected $blocksRoot;

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->addIdentifier('title', 'text');
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
            ->add('title', 'text')
            ->add('label', 'text', array('required' => false))
            //->add('body', 'textarea', array('required' => false))
            ->add('template', 'text', array('required' => false))
            //->add('extras', 'text', array('required' => false))
            ->add('content', 'doctrine_phpcr_odm_tree', array('choice_list' => array(), 'required' => false, 'select_root_node' => false, 'root_node' => $this->blocksRoot))
            ->add('block', 'doctrine_phpcr_odm_tree', array('choice_list' => array(), 'required' => false, 'select_root_node' => false, 'root_node' => $this->blocksRoot))
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
            ->add('title', 'doctrine_phpcr_string');
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
     * @param string $blocksRoot
     */
    public function setBlocksRoot($blocksRoot)
    {
        $this->blocksRoot = $blocksRoot;
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