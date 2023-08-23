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
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'max' => 80,
                        'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre nom ne peut pas faire plus de {{ limit }} caractères.',
                    ]),
                ],
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email([
                        'message' => 'L\'email {{ value }} n\'est pas un email valide.',
                    ]),
                ],
            ])
            ->add('media', FileType::class, [
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'L\'image est trop volumineuse la taille maximum est de {{ limit }} mb',
                        'extensions' => ['jpg', 'jpeg', 'png', 'webp'],
                        'extensionsMessage' => 'Mauvais format d\'image. Format acceptés : jpg, jpeg, png, webp.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'message' => 'Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un caractère spécial.',
                    ]),
                ],
            ])
            ->add('confirm_password', PasswordType::class)
            ->add('submit', SubmitType::class);

    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
