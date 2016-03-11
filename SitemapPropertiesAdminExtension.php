<?php
namespace nvbooster\StarterBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * SideMenuAdminExtension
 *
 * @author nvb <nvb@aproxima.ru>
 */
class SitemapPropertiesAdminExtension extends AdminExtension
{
        /**
     * @var double
     */
    protected $pageWeight;

    /**
     * @var string
     */
    protected $updatePeriod;

    /**
     * @var boolean
     */
    protected $visibleInSitemap;

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\AdminExtension::configureFormFields()
     */
    public function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Sitemap')
                ->add('visibleInSitemap', 'checkbox', array(
                    'label' => 'Add to sitemap',
                    'required' => false
                ))
                ->add('pageWeight', 'choice', array(
                    'required' => false,
                    'label' => 'Page priority',
                    'choices' => array(
                        null => 'default',
                        '0' => '0',
                        '0.1' => '0.1',
                        '0.2' => '0.2',
                        '0.3' => '0.3',
                        '0.4' => '0.4',
                        '0.5' => '0.5',
                        '0.6' => '0.6',
                        '0.7' => '0.7',
                        '0.8' => '0.8',
                        '0.9' => '0.9',
                        '1.0' => '1.0'
                    )
                ))
                ->add('updatePeriod', 'choice', array(
                    'required' => false,
                    'label' => 'Update frequency',
                    'choices' => array(
                        null => 'default',
                        'always' => 'always',
                        'hourly' => 'hourly',
                        'daily' => 'daily',
                        'weekly' => 'weekly',
                        'monthly' => 'monthly',
                        'yearly' => 'yearly',
                        'never' => 'never'
                    )
                ))
            ->end();
    }

}