<?php
namespace nvbooster\StarterBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * SideMenuAdminExtension
 *
 * @author nvb <nvb@aproxima.ru>
 */
class SideMenuAdminExtension extends AdminExtension
{
    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\AdminExtension::configureFormFields()
     */
    public function configureFormFields(FormMapper $form)
    {
        $form
            ->add(
                'sideMenu',
                'doctrine_phpcr_odm_tree',
                array('root_node' => $this->menuRoot, 'choice_list' => array(), 'select_root_node' => true))
            ->end();
    }
}