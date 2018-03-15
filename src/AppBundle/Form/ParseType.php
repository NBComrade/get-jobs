<?php

namespace AppBundle\Form;

use AppBundle\Entity\ParseData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $builder
            ->add('query', TextType::class)
           ->add('city', ChoiceType::class, [
               'choices'  => [ //todo hardcode - move to settings
                   'Kiev' => '1',
                   'Kharkov' => '21',
                   'Poltava' => '17',
               ],
           ])
            ->add('days', ChoiceType::class, [
                'choices'  => [ //todo hardcode - move to settings to
                    '1 day' => '2',
                    '7 day' => '3',
                ],
            ])
            ->add('save', SubmitType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ParseData::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_parse_form';
    }
}
