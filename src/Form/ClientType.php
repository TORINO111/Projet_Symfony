<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Ajoutez ce type si nécessaire
use Symfony\Component\Form\Extension\Core\Type\DateType; // Ajoutez ce type si nécessaire
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('adresse', TextareaType::class, [
                'label' => 'Adresse',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return  $user->getPrenom() . ' ' . $user->getNom() . ' - Login: ' .  $user->getLogin();
                },
                'placeholder' => 'Sélectionnez un utilisateur',
                'required' => false,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}

            // ->add('createdAt', DateType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'Date de création',
            // ])
            // ->add('updatedAt', DateType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'Date de mise à jour',
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            //     'label' => 'Utilisateur',
            // ])
        
