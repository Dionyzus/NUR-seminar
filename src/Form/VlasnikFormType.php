<?php
namespace App\Form;

use App\Entity\Vlasnik;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;

class VlasnikFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazivVlasnika', TextType::class)
            ->add('kontaktBroj', TextType::class)
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email(['message' => 'Please enter a valid email address.'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Vlasnik::class,
        ));
    }
}