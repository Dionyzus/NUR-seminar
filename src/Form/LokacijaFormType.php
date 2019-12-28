<?php

namespace App\Form;

use App\Entity\Lokacija;
use App\Entity\Ustanova;
use App\Entity\Organizacija;
use App\Entity\Namjena;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoiceToValueTransformer;

class LokacijaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brojUcionice', TextType::class, [
                'required' => true,
            ])
            ->add('ustanova', EntityType::class, [
                'class' => Ustanova::class,
                'choice_label' => function(Ustanova $ustanova) {
                    return sprintf('%s', $ustanova->getNazivUstanove());
                }
            ])
            ->add('organizacija', EntityType::class, [
                'class' => Organizacija::class,
                'choice_label' => function(Organizacija $organizacija) {
                    return sprintf('%s', $organizacija->getNazivOrganizacije());
                }
            ])
            ->add('namjena', EntityType::class, [
                'class' => Namjena::class,
                'choice_label' => function(Namjena $namjena) {
                    return sprintf('%s', $namjena->getNazivNamjene());
                }
            ])
            ->add('opis', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lokacija::class
        ]);
    }
}