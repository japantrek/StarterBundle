<?php

namespace nvbooster\StarterBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\DoctrinePHPCRAdminBundle\Form\Type\TreeModelType;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class RouteContainerAdmin extends Admin
{
    protected $translationDomain = 'nvstarter';

     /**
     * Root path for the route parent selection
     * @var string
     */
    protected $routeRoot;

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('path', 'text')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
                ->add('parentDocument', TreeModelType::class, array('choice_list' => array(), 'select_root_node' => true, 'root_node' => $this->routeRoot))
                ->add('name', TextType::class)
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', 'doctrine_phpcr_nodename')
        ;
    }

    /**
     * @param Object $routeRoot
     */
    public function setRouteRoot($routeRoot)
    {
        $this->routeRoot = $routeRoot;
    }

    /**
     * @return array
     */
    public function getExportFormats()
    {
        return array();
    }

    /**
     * @param Object $object
     *
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Route && $object->getId()
            ? $object->getId()
            : $this->trans('link_add', array(), 'SonataAdminBundle')
        ;
    }
}
