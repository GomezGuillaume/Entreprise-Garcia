<?php

namespace App\Form;

use App\Entity\Form;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                "label"=>"Nom"
            ])
            ->add('lastname', null, [
                "label"=>"Prénom"
            ])
            ->add('phone', null, [
                "label"=>"Téléphone"
            ])
            ->add('email', null, [
                "label"=>"E-mail"
            ])
            ->add('adress', null, [
                "label"=>"Adresse"
            ])
            ->add('message', null, [
                "label"=>"Message"
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Form::class,
        ]);
    }
}
