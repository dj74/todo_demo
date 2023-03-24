<?php

namespace App\Form;

use App\Entity\TodoItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TodoItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [ 'required' => false ])
            ->add('title', TextType::class, [ 'required' => true ])
            ->add('description', TextareaType::class, ['attr' => array('rows' => '5'), 'required' => false ])
            ->add('status', IntegerType::class, [ 'required' => false ])
            ->add('creation_ts', IntegerType::class, [ 'required' => false ])
            ->add('start_ts', IntegerType::class, [ 'required' => false ])
            ->add('completed_ts', IntegerType::class, [ 'required' => false ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TodoItem::class,
        ]);
    }
}
