<?php

declare(strict_types=1);

namespace App\Security\UserInterface\ViewModel;

use App\Shared\UserInterface\ViewModel\ViewModelInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class ResetPasswordViewModel implements ViewModelInterface
{
    public FormView $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form->createView();
    }
}
