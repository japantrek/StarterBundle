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
        $form->add('sideMenu', 'text', array(
            'required' => false
        ))->end();
    }
}