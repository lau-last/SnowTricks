<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('email', EmailType::class, ['required' => true,])
            ->add('media', FileType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'L\'image est trop volumineuse la taille maximum est de {{ limit }} mb',
                        'extensions' => ['jpg', 'jpeg', 'png', 'webp'],
                        'extensionsMessage' => 'Mauvais format d\'image. Format acceptés : jpg, jpeg, png, webp.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, ['required' => true,])
            ->add('confirm_password', PasswordType::class, ['required' => true,])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'mt-5 btn btn-primary'],
            ]);

    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
