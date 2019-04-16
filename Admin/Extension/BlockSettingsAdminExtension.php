<?php
namespace nvbooster\StarterBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Burgov\Bundle\KeyValueFormBundle\Form\Type\KeyValueType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            ->add('settings', KeyValueType::class, [
                'value_type' => TextType::class,
                'required' => false,
            ])
            ->end();
    }
}