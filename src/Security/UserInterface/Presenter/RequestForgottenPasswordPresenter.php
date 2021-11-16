<?php

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
