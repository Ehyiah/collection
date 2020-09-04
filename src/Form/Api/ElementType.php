<?php

namespace App\Form\Api;

use App\Entity\Element;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextType::class, [
                'required' => false
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Trés Mauvais état' => Element::ETAT_VERY_BAD,
                    'Mauvais état' => Element::ETAT_BAD,
                    'Bon état' => Element::ETAT_GOOD,
                    'Trés bon état' => Element::ETAT_VERY_GOOD,
                    'Quasi neuf' => Element::ETAT_MINT,
                    'Neuf' => Element::ETAT_NEW
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Element::class,
            'csrf_protection' => false
        ]);
    }
}
