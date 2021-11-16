<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Controller;

use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordInterface;
use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordPresenterInterface;
use App\Security\UserInterface\Form\RequestForgottenPasswordType;
use App\Security\UserInterface\Input\RequestForgottenPasswordInput;
use App\Security\UserInterface\Responder\RequestForgottenPassword\RequestForgottenPasswordResponderInterface;
use App\Security\UserInterface\ViewModel\RequestForgottenPasswordViewModel;
use App\Shared\Domain\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequestForgottenPasswordController
{
    public function __invoke(
        Request $request,
        FormFactoryInterface $formFactory,
        RequestForgottenPasswordResponderInterface $responder,
        RequestForgottenPasswordPresenterInterface $presenter,
        RequestForgottenPasswordInterface $useCase,
    ): Response {
        $input = new RequestForgottenPasswordInput();

        $form = $formFactory->create(RequestForgottenPasswordType::class, $input)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $useCase($input, $presenter);

                return $responder->redirect();
            } catch (InvalidArgumentException $exception) {
                $form->addError(new FormError($exception->getMessage()));
            }
        }

        return $responder->send(new RequestForgottenPasswordViewModel($form));
    }
}
