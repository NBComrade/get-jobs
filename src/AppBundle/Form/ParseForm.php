<?php

namespace AppBundle\Form;

use AppBundle\Entity\ParseData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $builder
            ->add('query', TextType::class)
            ->add('city', TextType::class)
            ->add('days', ChoiceType::class, [
                'choices'  => [
                    '1 day' => 'hello world',
                    '7 day' => 'word hello',
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
