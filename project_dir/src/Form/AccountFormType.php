<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accountType', ChoiceType::class, [
                'choices' => [
                    'Savings' => 'Savings',
                    'Checking' => 'Checking',
                    'Investment' => 'Investment',
                ],
                'label' => 'Account Type',
            ])
            ->add('currency', ChoiceType::class, [
                'choices' => [
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'RON' => 'RON',
                ],
                'label' => 'Currency',
            ])
            ->add('balance', MoneyType::class, [
                'currency' => false,
                'label' => 'Initial Balance',
                'scale' => 4,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
