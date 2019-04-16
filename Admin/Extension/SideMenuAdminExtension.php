<?php
namespace nvbooster\StarterBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Form\Type\TreeModelType;

/**
 * SideMenuAdminExtension
 *
 * @author nvb <nvb@aproxima.ru>
 */
class SideMenuAdminExtension extends AdminExtension
{
    /**
     * @var string
     */
    private $menuRoot;

    /**
     * @param string $menuRoot
     */
    public function setMenuRoot($menuRoot)
    {
        $this->menuRoot = $menuRoot;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\AdminExtension::configureFormFields()
     */
    public function configureFormFields(FormMapper $form)
    {
        $form
            ->add('sideMenu', TreeModelType::class, array(
                'required' => false,
                'root_node' => $this->menuRoot,
                'choice_list' => [],
                'select_root_node' => false)
            )
            ->end();
    }
}