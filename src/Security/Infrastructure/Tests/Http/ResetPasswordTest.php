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

namespace App\Security\Infrastructure\Tests\Http;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Date\DateTime;
use App\Shared\Domain\ValueObject\Date\Interval;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

final class ResetPasswordTest extends WebTestCase
{
    public function testIfResetPasswordIsSuccessful(): void
    {
        $client = static::createClient();

        /** @var UserGateway<User> $userGateway */
        $userGateway = $client->getContainer()->get(UserGateway::class);

        /** @var User $user */
        $user = $userGateway->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));

        $user->requestForAForgottenPassword();
        $userGateway->update($user);

        $client->request(
            Request::METHOD_GET,
            sprintf('/security/reset-password/%s', (string) $user->forgottenPasswordToken)
        );

        $this->assertResponseIsSuccessful();

        $client->submitForm('Reset', [
            'reset_password[password]' => 'new_password',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        /** @var User $user */
        $user = $userGateway->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));

        $this->assertNull($user->forgottenPasswordToken);
        $this->assertNull($user->forgottenPasswordRequestedAt);
        $this->assertFalse($user->canResetPassword());
    }

    public function testIfResetPasswordWithEmptyPlainPasswordIsFailed(): void
    {
        $client = static::createClient();

        /** @var UserGateway<User> $userGateway */
        $userGateway = $client->getContainer()->get(UserGateway::class);

        /** @var User $user */
        $user = $userGateway->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));

        $user->requestForAForgottenPassword();
        $userGateway->update($user);

        $client->request(
            Request::METHOD_GET,
            sprintf('/security/reset-password/%s', (string) $user->forgottenPasswordToken)
        );

        $this->assertResponseIsSuccessful();

        $client->submitForm('Reset', [
            'reset_password[password]' => '',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfForgottenPasswordRequestIsExpired(): void
    {
        $client = static::createClient();

        /** @var UserGateway<User> $userGateway */
        $userGateway = $client->getContainer()->get(UserGateway::class);

        /** @var User $user */
        $user = $userGateway->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));

        $user->requestForAForgottenPassword();
        /** @var DateTime $date */
        $date = $user->forgottenPasswordRequestedAt;
        $user->forgottenPasswordRequestedAt = $date->sub(Interval::createFromString(('P2D')));
        $userGateway->update($user);

        $client->request(
            Request::METHOD_GET,
            sprintf('/security/reset-password/%s', (string) $user->forgottenPasswordToken)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testIfForgottenPasswordTokenDoesNotExist(): void
    {
        $client = static::createClient();

        $client->request(
            Request::METHOD_GET,
            sprintf('/security/reset-password/%s', (string) Uuid::v4())
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
