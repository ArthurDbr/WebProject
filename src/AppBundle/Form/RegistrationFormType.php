<?php
namespace AppBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

    class RegistrationFormType extends AbstractType
    {
      /**
       * {@inheritdoc}
       */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            parent::buildForm($builder, $options);

        }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'appBundle_users_registration';
    }
       public function getName()
        {
            return 'AppBundle_users_registration';
        }
    }

?>
