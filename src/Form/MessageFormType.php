<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['required' => true])
            ->add('lastName', null, ['required' => true])

            ->add('topic', ChoiceType::class, [
                'choices'  => [
                    'Prestation Photographie' => 'Prestation Photographie',
                    'Prestation Vidéo' => 'Prestation Vidéo',
                    'Autre' => 'Autre',
                ],
                'required' => false
            ])

            ->add('otherTopic', TextareaType::class, ['attr' => ['maxlength' => '255'],'required' => false])

            ->add('date')

            ->add('howDoYouKnowMe', ChoiceType::class, [
                'choices'  => [
                    'Youtube' => 'Youtube',
                    'LinkedIn' => 'LinkedIn',
                ],
                'required' => false
            ])

            ->add('email', EmailType::class, ['help' => 'Nous ne partagerons jamais votre email.',])
            ->add('content', TextareaType::class, ['attr' => ['maxlength' => '2000'],])
            ->add('envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary'],])
            ->add('captcha', CaptchaType::class, [
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
