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

namespace App\Security\UserInterface\Presenter;

use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordOutput;
use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordPresenterInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class RequestForgottenPasswordPresenter implements RequestForgottenPasswordPresenterInterface
{
    public function __construct(private MailerInterface $mailer, private string $emailNoReply)
    {
    }

    public function present(RequestForgottenPasswordOutput $output): void
    {
        $this->mailer->send(
            (new TemplatedEmail())
                ->from(new Address($this->emailNoReply))
                ->to(new Address((string) $output->user->email))
                ->subject('Your forgotten password request')
                ->htmlTemplate('@security/emails/request_forgotten_password.html.twig')
                ->context(['user' => $output->user])
        );
    }
}
