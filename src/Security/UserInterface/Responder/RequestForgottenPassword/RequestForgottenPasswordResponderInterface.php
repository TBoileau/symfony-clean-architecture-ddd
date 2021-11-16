<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Responder\RequestForgottenPassword;

use App\Security\UserInterface\ViewModel\RequestForgottenPasswordViewModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

interface RequestForgottenPasswordResponderInterface
{
    public function send(RequestForgottenPasswordViewModel $viewModel): Response;

    public function redirect(): RedirectResponse;
}
