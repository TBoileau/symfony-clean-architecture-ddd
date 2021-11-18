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

namespace App\Security\UserInterface\Controller;

use App\Security\Domain\Entity\User;
use App\Security\Domain\UseCase\ResetPassword\ResetPasswordInterface;
use App\Security\Infrastructure\Symfony\Security\Voter\UserVoter;
use App\Security\UserInterface\Form\ResetPasswordType;
use App\Security\UserInterface\Input\ResetPasswordInput;
use App\Security\UserInterface\Responder\ResetPassword\ResetPasswordResponderInterface;
use App\Security\UserInterface\ViewModel\ResetPasswordViewModel;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class ResetPasswordController
{
    public function __invoke(
        User $user,
        Request $request,
        AuthorizationCheckerInterface $authorizationChecker,
        FormFactoryInterface $formFactory,
        ResetPasswordResponderInterface $responder,
        ResetPasswordInterface $useCase,
    ): Response {
        if (!$authorizationChecker->isGranted(UserVoter::CAN_RESET_PASSWORD, $user)) {
            throw new BadRequestException('Token invalid.');
        }

        $input = new ResetPasswordInput($user);
        $form = $formFactory->create(ResetPasswordType::class, $input)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $useCase($input);

                return $responder->redirect();
            } catch (Exception) {
                throw new BadRequestException('Token invalid.');
            }
        }

        return $responder->send(new ResetPasswordViewModel($form));
    }
}
