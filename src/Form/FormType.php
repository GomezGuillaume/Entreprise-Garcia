<?php

namespace App\Form;

use App\Entity\Form;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                "label"=>"Nom"
            ])
            ->add('lastname', TextType::class, [
                "label"=>"Prénom"
            ])
            ->add('phone', TextType::class, [
                "label"=>"Téléphone"
            ])
            ->add('email', EmailType::class, [
                "label"=>"E-mail"
            ])
            ->add('adress', TextType::class, [
                "label"=>"Adresse"
            ])
            ->add('message', TextareaType::class, [
                "label"=>"Message"
            ])
            ->add('submit', SubmitType::class, [
                "label"=>"Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Form::class,
        ]);
    }
}
