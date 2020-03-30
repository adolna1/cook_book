<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ChangePasswordFormType.
 */
class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Uzupełnuj hasło',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Hasło musi posiadać minimum 6 znaków',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
            'invalid_message' => 'Hasła muszą być takie same',
            'required' => true,
            'first_options' => ['label' => 'hasło'],
            'second_options' => ['label' => 'powtórz hasło'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class, ]
        );
    }
}
