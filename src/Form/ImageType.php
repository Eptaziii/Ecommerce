<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Jeux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, array('label' => 'Image', 'mapped'=>false,'attr' => ['class'=>'form-control'], 'label_attr' => ['class'=> 'fw-bold'],'constraints' => [
                new File([
                'maxSize' => '10000k',
                'mimeTypes' => [
                    'application/pdf',
                    'application/x-pdf',
                    'image/jpeg',
                    'image/png',
                ],
                'mimeTypesMessage' => 'Le site accepte uniquement les fichiers PDF, PNG et JPG',
                ])
            ],))
            ->add('jeux', EntityType::class, [
                'class' => Jeux::class,
                'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold'],
                'choice_label' => 'nom',
            ])
            ->add('ajouter', SubmitType::class, ['attr' => ['class'=> 'btn bg-primary text-white m-4' ],'row_attr' => ['class' => 'text-center'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
