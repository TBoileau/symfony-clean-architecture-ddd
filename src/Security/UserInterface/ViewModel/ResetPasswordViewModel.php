<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

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
