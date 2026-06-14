<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\CallbackTransformer;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER',
                'Invité' => 'ROLE_INVITE',
       ],
    ])
            ->add('password', PasswordType::class);

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            function ($rolesAsArray) {
                return count($rolesAsArray) ? $rolesAsArray[0] : null;
            },
            function ($rolesAsString) {
                return [$rolesAsString];
            }
        ));

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
