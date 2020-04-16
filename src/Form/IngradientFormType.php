<?php


namespace App\Form;


use App\Entity\Ingradients;
use App\Entity\RecipyIngradients;
use App\Form\DataTransformer\IngredeintsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngradientFormType extends AbstractType
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
           ->add('ingradient', TextType::class, [
               'label' => 'label_tags',
               'required' => false,
           ])
           ->add('measurment');

       $builder->get('ingradient')->addModelTransformer(
           $this->ingredientsDataTransformer
       );
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