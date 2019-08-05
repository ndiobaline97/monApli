<?php

namespace App\Form;

use App\Entity\Partenaire;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numCompte')
            ->add('entreprise')
            ->add('ninea')
            ->add('adresse')
            ->add('email')
            ->add('telephone')
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
