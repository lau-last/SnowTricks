<?php

namespace App\Form;

use App\Entity\TrickPicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickPictureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'required' => false,
                'attr' => ['class' => 'picture-fields'],
            ])
            ->add('alt', TextType::class, [
                'required' => true,
                'label' => 'Sentence to describe the photo'
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrickPicture::class,
        ]);
    }


}
