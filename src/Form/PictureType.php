<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PictureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileName', FileType::class, [
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '10M',
                        'maxSizeMessage' => 'L\'image est trop volumineuse la taille maximum est de {{ limit }} mb',
                        'extensions' => ['jpg', 'jpeg', 'png', 'webp'],
                        'extensionsMessage' => 'Mauvais format d\'image. Format acceptés : jpg, jpeg, png, webp.',
                    ]),
                ],
                'required' => false,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }


}
