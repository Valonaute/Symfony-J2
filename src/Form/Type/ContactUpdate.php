<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface as FormFormBuilderInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;

class ContactUpdate extends AbstractType {

    public function buildForm(FormFormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', null, ['label' => 'Nom', 'attr' => ['class' => 'text-center', 'id' => 'nom', 'name' => 'nom']])
            ->add('Prenom', null, ['label' => 'Prenom', 'attr' => ['placeholder' => 'Votre prénom']])
            ->add('Email', EmailType::class, ['label' => 'Email', 'attr' => ['placeholder' => 'Votre email']])
            ->add('valider', SubmitType::class, ['label' => 'Valider Formulaire', 'attr' => ['class' => 'btn btn-danger', 'name' => 'validate']])
            ;
    }

}