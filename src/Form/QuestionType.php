<?php

namespace App\Form;

use App\Entity\Question;
use App\Form\JsonToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'label' => "Question"
            ])
            ->add('answer', TextareaType::class, [
                'label' => "Réponse",
                'attr' => ['class' => 'tinymce'],
                'data' => $options['data']->getAnswer(), // Ensure JSON data is set to textarea
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}