<?php
namespace AppBundle\Form;

    use Symfony\Component\Form\FormBuilderInterface;
    use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

    class RegistrationFormType extends BaseType
    {
      /**
       * {@inheritdoc}
       */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            parent::buildForm($builder, $options);

            // Ajoutez vos champs ici, revoilà notre champ *location* :
            $builder->add('nom')->add('age')->add('prenom');
        }

       public function getName()
        {
            return 'AppBundle_users_registration';
        }
    }
?>
