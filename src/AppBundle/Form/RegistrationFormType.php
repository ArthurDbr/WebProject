<?php
namespace AppBundle\Form;

    use Symfony\Component\Form\FormBuilder;
    use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

    class RegistrationFormType extends BaseType
    {
      /**
       * {@inheritdoc}
       */
        public function buildForm(FormBuilder $builder, array $options)
        {
            parent::buildForm($builder, $options);

            // Ajoutez vos champs ici, revoilà notre champ *location* :
            $builder->add('nom')->('age')->('prenom')->('id');
        }

      /*  public function getName()
        {
            return 'AppBundle_users';
        }*/
    }
?>
