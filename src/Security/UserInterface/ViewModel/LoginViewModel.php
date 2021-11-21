<?php

declare(strict_types=1);

namespace App\Security\UserInterface\ViewModel;

use App\Shared\UserInterface\ViewModel\ViewModelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final class LoginViewModel implements ViewModelInterface
{
    public function __construct(public string $lastUsername, public ?AuthenticationException $error)
    {
    }
}
