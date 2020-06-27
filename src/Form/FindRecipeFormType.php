<?php


namespace App\Form;


use App\Entity\Categories;
use App\Entity\Ingradients;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FindRecipeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('category', EntityType::class, [
               'class' => Categories::class,
               'choice_label' => 'name',
               'placeholder' => 'category_placeholder',
           ]);
       $builder->add('ingredients', EntityType::class, [
           'class' => Ingradients::class,
           'choice_label' => 'name',
           'multiple' => true,
           'expanded' => true,
       ]);
    }

}