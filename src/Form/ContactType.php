<?php

namespace App\Form;

use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                "label" => "Nom"
            ])
            ->add('firstname', TextType::class, [
                "label" => 'Prénom'
            ])
            ->add('email', EmailType::class, [
                "label" => 'E-mail'
            ])
            ->add('phone', NumberType::class, [
                "label" => "Téléphone"
            ])
            ->add('adress', TextType::class, [
                "label" => "Adresse"
            ])

            ->add('content', TextareaType::class, [
                "label" => 'Votre message'
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
