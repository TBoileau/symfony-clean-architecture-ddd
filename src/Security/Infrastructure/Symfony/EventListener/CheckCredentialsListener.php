<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\EventListener;

use App\Security\Domain\Entity\User;
use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
use App\Security\Infrastructure\Symfony\Security\Authenticator\Passport\PasswordCredentials;
use App\Security\Infrastructure\Symfony\Security\User\UserProxy;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

final class CheckCredentialsListener implements EventSubscriberInterface
{
    public function __construct(private PasswordHasherInterface $passwordHasher)
    {
    }

    public function checkPassport(CheckPassportEvent $checkPassportEvent): void
    {
        /** @var Passport $passport */
        $passport = $checkPassportEvent->getPassport();
        $userProxy = $passport->getUser();
        if (!$userProxy instanceof UserProxy || !$passport->hasBadge(PasswordCredentials::class)) {
            return;
        }
        /** @var PasswordCredentials $passwordCredentials */
        $passwordCredentials = $passport->getBadge(PasswordCredentials::class);
        if ($passwordCredentials->isResolved()) {
            return;
        }
        /** @var User $user */
        $user = $userProxy->user;
        if (null === $user->hashedPassword) {
            throw new BadCredentialsException('Invalid credentials.');
        }
        $passwordCredentials->verify($this->passwordHasher, $user->hashedPassword);
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [CheckPassportEvent::class => 'checkPassport'];
    }
}
