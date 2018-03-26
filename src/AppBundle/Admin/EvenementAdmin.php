<?php
namespace AppBundle\Admin;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use AppBundle\Entity\Evenement;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Validator\ErrorElement;

class EvenementAdmin extends AbstractAdmin
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
            ->add('description')
            ->add('lieu')
            ->add('idPersonne')
            ->add('idTypeEvenement')
            ->add('dateEvenement')
            ->add('heureEvenement')
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
                ->add('description')
                ->add('lieu')
                ->add('idPersonne')
                ->add('idTypeEvenement')
//                ->add(strtotime('dateEvenement'), DateType::class, array(
//                    'format' => 'yyyy-MM-dd'
//                    ))
//                ->add('heureEvenement')
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
            ->add('description')
            ->add('lieu')
            ->add('idPersonne')
            ->add('idTypeEvenement')
            ->add('dateEvenement')
            ->add('heureEvenement')
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
            ->add('description')
            ->add('lieu')
            ->add('idPersonne')
            ->add('idTypeEvenement')
            ->add('dateEvenement')
            ->add('heureEvenement')
        ;
    }
}
?>