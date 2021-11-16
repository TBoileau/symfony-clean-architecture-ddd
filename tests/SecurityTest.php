<?php

declare(strict_types=1);

namespace App\Tests;

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

        $this->assertResponseIsSuccessful();

        $client->submitForm('Sign in', [
            'email' => 'user+1@email.com',
            'password' => 'password',
        ]);

        $this->assertResponseIsSuccessful();

        $client->clickLink('Logout');

        $this->assertResponseIsSuccessful();
    }
}
