<?php
namespace App\Form;

use App\DTO\ClientSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'required' => false,
                'label' => 'Surname',
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => 'Téléphone',
            ])
            ->add('hasUser', CheckboxType::class, [
                'required' => false,
                'label' => 'A un utilisateur',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientSearch::class,
        ]);
    }
}

