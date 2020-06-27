<?php


namespace App\Form;


use App\Entity\Categories;
use App\Entity\Recipes;
use App\Entity\Tags;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RecipeFormType
 * @package App\Form
 */
class RecipeFormType extends AbstractType
{
    /**
     * @var TagsDataTransformer
     */
    private TagsDataTransformer $tagsDataTransformer;

    public function __construct(TagsDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'title'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'description_form'
            ]);

        $builder
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Image([
                        'maxSize' => '5M'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Choose image',
                    'class' => 'image_input'
                ],
                'label' => 'image_form'
            ]);

        $builder
            ->add('recipyIngradients', CollectionType::class, [
                'entry_type' => IngradientFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'ingredient_form'
            ]);

        $builder
            ->add('category', EntityType::class, [
               'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'category_form',
                'placeholder' => 'category_placeholder'
            ]);

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );

        $builder
            ->add('save', SubmitType::class, [
                'label' => 'save'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Recipes::class,
        ]);
    }
}