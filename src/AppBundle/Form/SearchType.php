<?php
namespace AppBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use FOS\UserBundle\Form\Type\SearchType as BaseType;

    class SearchType extends AbstractType
    {
      /**
       * {@inheritdoc}
       */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            parent::buildForm($builder, $options);
            $builder->add('Description', null, array(
              'required'   => false,
              'empty_data' => 'donnez la description',
            ));



        }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'appBundle_evenement_registration';
    }
       public function getName()
        {
            return 'AppBundle_evenement_registration';
        }
    }

?>
