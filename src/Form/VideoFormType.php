<?php

namespace App\Form;

use App\Entity\Video;
use App\Entity\VideoCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => VideoCategory::class,
                'label' => 'Catégorie',
                'choice_label' => 'title',
            ])
            ->add('valider', SubmitType::class, ['attr' => ['class' => 'btn btn-success'],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
