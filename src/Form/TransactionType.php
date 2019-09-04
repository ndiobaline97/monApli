<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomE')
            ->add('prenomE')
            ->add('adresse')
            ->add('telephoneE')
            //->add('dateEnvoie')
            //->add('numTransaction')
            ->add('typePiece')
            ->add('numPiece')
            //->add('dateDelivrance')
            //->add('dateExpiration')
            ->add('montant')
            ->add('nomB')
            ->add('prenomB')
            ->add('adresseB')
            ->add('telephoneB')
            //->add('codeEnvoie')
            ->add('commissionUser')
            ->add('commissionSysteme')
            ->add('commissionEtat')
            ->add('fraisEnvoie')
            ->add('total')
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
