<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\CallbackTransformer;

class ModifRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, ['mapped'=> false, 'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=>'fw-bold'],
            'choices' => [
                '-' => null,
                'Administrateur' => 'ROLE_ADMIN',
                'Modérateur' => 'ROLE_MOD',
                'Utilisateur' => '',
            ],
            ])
            ->add('modifier', SubmitType::class, ['attr' => ['class'=> 'btn bg-primary text-white m-4' ],'row_attr' => ['class' => 'text-center'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
