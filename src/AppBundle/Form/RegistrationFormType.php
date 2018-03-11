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
          $builder->add('nom')->add('age')->add('prenom');
            parent::buildForm($builder, $options);

            // Ajoutez vos champs ici, revoilà notre champ *location* :

        }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
       public function getName()
        {
            return 'AppBundle_users_registration';
        }
    }

?>
