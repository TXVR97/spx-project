<?php

namespace App\Form;

use App\Entity\Structure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Nom de la structure"
                ],
                

            ])
            ->add('adress', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Adresse"
                ],
               
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('manager', EmailType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Email du manager"
                ],
                
            ])
            ->add('status',CheckboxType::class, [
                "label" => false,
                'help' => 'Cocher si \'\'actif\'\'',
               
            ])
            ->add('partner');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
