<?php
namespace nvbooster\StarterBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * BlockSettingsAdminExtension
 *
 * @author nvb <nvb@aproxima.ru>
 */
class BlockSettingsAdminExtension extends AdminExtension
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
                'settings',
                'burgov_key_value',
                array(
                    'value_type' => 'text',
                    'required' => false
                )
            )
            ->end();
    }
}