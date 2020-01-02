<?php

namespace App\Form;

use App\Entity\Kategorija;
use App\Entity\Lokacija;
use App\Entity\Ustanova;
use App\Entity\Organizacija;
use App\Entity\Namjena;
use App\Entity\Vlasnik;
use App\Entity\Hardware;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoiceToValueTransformer;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brojUcionice', EntityType::class, [
                'class' => Lokacija::class,
                'choice_label' => function(Lokacija $lokacija) {
                    return sprintf('%s', $lokacija->getBrojUcionice());
                }
            ])
        ;
    }
}