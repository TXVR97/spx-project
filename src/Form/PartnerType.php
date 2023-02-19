<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                "label" => false,
                "attr" => [
                    "placeholder" => "Nom du partenaire"
                ],
                
                
                
            ])
            
            ->add('description', TextareaType::class,[
                "label" => false,
                "attr" => [
                    "placeholder" => "Description"
                ],
                
            ])
            ->add('ComContact', EmailType::class,[
                "label" => false,
                "attr" => [
                    "placeholder" => "Email du commercial"
                ],
                
            ])
            ->add('website', UrlType::class,[
                "label" => false,
                "attr" => [
                    "placeholder" => "URL du site"
                ],
                
            ])
            ->add('ManageContact', EmailType::class,[
                "label" => false,
                "attr" => [
                    "placeholder" => "Email du Manager"
                ],
                
            ])
            ->add('City',TextType::class,[
                "label" => false,
                "attr" => [
                    "placeholder" => "Ville"
                ],
                
            ])
           
            ->add('image')
            ->add('status',CheckboxType::class, [
                "label" => false,
                'help' => 'Cocher si \'\'actif\'\'',
               
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
