<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use AppBundle\Entity\Users;

class UsersAdmin extends AbstractAdmin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('enabled')
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('template', 'choice', [
                'choices' => [
                    1 => 'Orange',
                    2 => 'Gris'
                    ]
            ])
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('enabled')
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('template', 'choice', [
                'choices' => [
                    'United' => 'Orange',
                    'Flatly' => 'Bleu'
                ]
            ])
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('enabled')
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('template')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('enabled')
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('template')
        ;
    }
}
?>