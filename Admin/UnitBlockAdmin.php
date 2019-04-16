<?php
namespace nvbooster\StarterBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use nvbooster\StarterBundle\Document\UnitBlock;
use Sonata\DoctrinePHPCRAdminBundle\Form\Type\TreeModelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

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
    protected $translationDomain = 'nvstarter';

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
                ->add('parentDocument', TreeModelType::class, array('choice_list' => array(), 'root_node' => $this->getRootPath()))
                ->add('name', TextType::class)
                ->add('title', TextType::class, array('required' => false))
                ->add('image', TextType::class, array('required' => false))
                ->add('route', TextType::class, array('required' => false))
                ->add('url', UrlType::class, array('required' => false))
                ->add('text', TextareaType::class)
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
