<?php

namespace AppBundle\Form;

use AppBundle\Entity\SearchSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domain', TextType::class)
            ->add('pattern', TextType::class)
            ->add('title', TextType::class)
            ->add('link', TextType::class)
            ->add('company', TextType::class)
            ->add('date', TextType::class)
            ->add('image', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchSetting::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_setting_type';
    }
}
