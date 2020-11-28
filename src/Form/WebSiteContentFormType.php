<?php

namespace App\Form;

use App\Entity\WebSiteContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebSiteContentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('about', TextareaType::class)
            ->add('location', TextareaType::class)
            ->add('adresse')
            ->add('email')
            ->add('phone')
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->add('youtube')
            ->add('linkedin')
            ->add('valider', SubmitType::class, ['attr' => ['class' => 'btn btn-success'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WebSiteContent::class,
        ]);
    }
}
