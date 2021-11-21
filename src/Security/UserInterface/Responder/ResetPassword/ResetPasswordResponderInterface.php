<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Responder\ResetPassword;

use App\Security\UserInterface\ViewModel\ResetPasswordViewModel;
    use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

interface ResetPasswordResponderInterface
{
    public function send(ResetPasswordViewModel $viewModel): Response;

    public function redirect(): RedirectResponse;
}
