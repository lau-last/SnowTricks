<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class VideoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('url', TextType::class, [
            'constraints' => [
                new Assert\AtLeastOneOf([
                    new Assert\Regex([
                        'pattern' => '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|v\/)?)([\w\-]+)(\S+)?$/',
                        'message' => 'L\'URL de la vidéo est invalide, veuillez insérer l\'URL d\'une vidéo Youtube ou Dailymotion.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/',
                        'message' => 'L\'URL de la vidéo est invalide, veuillez insérer l\'URL d\'une vidéo Youtube ou Dailymotion.',
                    ]),
                ]),
            ],
            'required' => false,
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }


}
