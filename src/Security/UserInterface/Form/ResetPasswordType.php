<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Form;

use App\Security\UserInterface\Input\ResetPasswordInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ResetPasswordType extends AbstractType
{
    /**
     * @param array<string, int|bool|string|null> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('password', PasswordType::class, ['empty_data' => '']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', ResetPasswordInput::class);
    }
}
