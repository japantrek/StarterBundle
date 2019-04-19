<?php
namespace nvbooster\StarterBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
     * @var string
     */
    protected $formTab;

    /**
     * @param string $formTab
     */
    public function __construct($formTab = '')
    {
        $this->formTab = $formTab;
    }

    /**
     * @var string
     */
    protected $translationDomain = 'nvstarter';

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\AdminExtension::configureFormFields()
     */
    public function configureFormFields(FormMapper $form)
    {
        if ($form->hasOpenTab()) {
            $form->end();
        }
        $form
            ->tab($this->formTab, [])
            ->with('form.group_sitemap', ['translation_domain' => $this->translationDomain])
                ->add('visibleInSitemap', CheckboxType::class, [
                    'required' => false,
                    'translation_domain' => $this->translationDomain,
                ])
                ->add('pageWeight', ChoiceType::class, [
                    'required' => false,
                    'translation_domain' => $this->translationDomain,
                    'choice_translation_domain' => $this->translationDomain,
                    'choices' => [
                        'value.weight.default' => null,
                        '0' => 0.0,
                        '0.1' => 0.1,
                        '0.2' => 0.2,
                        '0.3' => 0.3,
                        '0.4' => 0.4,
                        '0.5' => 0.5,
                        '0.6' => 0.6,
                        '0.7' => 0.7,
                        '0.8' => 0.8,
                        '0.9' => 0.9,
                        '1.0' => 1.0,
                    ],
                ])
                ->add('updatePeriod', ChoiceType::class, [
                    'required' => false,
                    'translation_domain' => $this->translationDomain,
                    'choice_translation_domain' => $this->translationDomain,
                    'choices' => [
                        'value.period.default' => null,
                        'value.period.always' => 'always',
                        'value.period.hourly' => 'hourly',
                        'value.period.daily' => 'daily',
                        'value.period.weekly' => 'weekly',
                        'value.period.monthly' => 'monthly',
                        'value.period.yearly' => 'yearly',
                        'value.period.never' => 'never',
                    ],
                ])
            ->end();
    }
}