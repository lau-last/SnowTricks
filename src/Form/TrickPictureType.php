<?php

namespace App\Form;

use App\Entity\TrickPicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TrickPictureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '10M',
                        'maxSizeMessage' => 'L\'image est trop volumineuse la taille maximum est de {{ limit }} mb',
                        'extensions' => ['jpg', 'jpeg', 'png', 'webp'],
                        'extensionsMessage' => 'Mauvais format d\'image. Format acceptés : jpg, jpeg, png, webp.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('alt', TextType::class);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrickPicture::class,
        ]);
    }


}
