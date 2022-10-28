<?php

namespace App\Form;

use App\Entity\Structure;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                "label" => 'Nom de la structure',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('adress', TextType::class,[
                "label" => 'Adresse',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('manager', EmailType::class,[
                "label" => 'Email manager',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true
            ])
            ->add('status')
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
