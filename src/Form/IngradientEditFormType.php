<?php


namespace App\Form;


use App\Entity\Ingradients;
use App\Entity\MeasurmentUnits;
use App\Entity\RecipyIngradients;
use App\Form\DataTransformer\IngredeintsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngradientEditFormType extends AbstractType
{
    /**
     * @var IngredeintsDataTransformer
     */
    private IngredeintsDataTransformer $ingredientsDataTransformer;

    public function __construct(IngredeintsDataTransformer $dataTransformer)
    {
        $this->ingredientsDataTransformer = $dataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingradient', EntityType::class, [
                'class' => Ingradients::class,
                'choice_label' => 'name',
                'label' => 'label_tags',
                'required' => false,
            ])
            ->add('measurment', NumberType::class, [
                'label' => 'measurment_form'
            ])
            ->add('measurmentUnit', EntityType::class, [
                'class' => MeasurmentUnits::class,
                'choice_label' => 'name',
                'label' => 'measurment_unit_form'
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecipyIngradients::class,
        ]);
    }
}