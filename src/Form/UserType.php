<?php

namespace App\Form;
use App\Entity\User ;
use App\Entity\Profile;
use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Security\Core\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;




class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('Partenaire', EntityType::class,[
                "class"=> Partenaire::class,
                'choice_label'=> 'partenaire_id'
            ])
            ->add('profile', EntityType::class,[
                "class"=> Profile::class,
                'choice_label'=> 'profile_id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
