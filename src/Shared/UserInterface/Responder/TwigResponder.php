<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Responder;

use App\Shared\UserInterface\ViewModel\ViewModelInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class TwigResponder
{
    public function __construct(private Environment $twig)
    {
    }

    public function send(string $template, ViewModelInterface $viewModel): Response
    {
        return new Response($this->twig->render($template, ['vm' => $viewModel]));
    }
}
