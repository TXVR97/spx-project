<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;


class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                "label" => 'Nom du Partenaire',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            
            ->add('description', TextareaType::class,[
                "label" => 'Description',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true
            ])
            ->add('ComContact', EmailType::class,[
                "label" => 'Email commerciale',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true
            ])
            ->add('website', UrlType::class,[
                "label" => 'URL du site',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true
            ])
            ->add('ManageContact', EmailType::class,[
                "label" => 'Email manager',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true
            ])
            ->add('City',TextType::class,[
                "label" => 'Ville',
                "attr" => [
                    "placeholder" => ""
                ],
                "required" => true
            ])
           
            ->add('image')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
