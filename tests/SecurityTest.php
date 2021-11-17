<?php

declare(strict_types=1);

namespace App\Tests;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use Blackfire\Bridge\PhpUnit\BlackfireTestCase;
use Blackfire\Build\BuildHelper;

final class SecurityTest extends BlackfireTestCase
{
    protected const BLACKFIRE_SCENARIO_AUTO_START = false;

    public function testSecurity(): void
    {
        $buildHelper = BuildHelper::getInstance();
        $buildHelper->createScenario('Security');

        $client = static::createBlackfiredHttpBrowserClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $client->clickLink('Forgot your password ?');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Request', [
            'request_forgotten_password[email]' => 'user+1@email.com',
        ]);

        static::bootKernel();

        /** @var User $user */
        $user = static::getContainer()
            ->get(UserGateway::class)
            ->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));

        $client->request('GET', sprintf('/security/reset-password/%s', (string) $user->forgottenPasswordToken));

        $this->assertResponseIsSuccessful();

        $client->submitForm('Reset', [
            'reset_password[password]' => 'new_password',
        ]);

        $this->assertResponseIsSuccessful();

        $client->submitForm('Sign in', [
            'email' => 'user+1@email.com',
            'password' => 'new_password',
        ]);

        $this->assertResponseIsSuccessful();

        $client->clickLink('Logout');

        $this->assertResponseIsSuccessful();
    }
}
