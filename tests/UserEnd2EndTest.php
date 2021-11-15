<?php

declare(strict_types=1);

namespace App\Tests;

use Blackfire\Bridge\PhpUnit\BlackfireTestCase;
use Blackfire\Build\BuildHelper;

final class UserEnd2EndTest extends BlackfireTestCase
{
    protected const BLACKFIRE_SCENARIO_AUTO_START = false;

    public function testSecurity(): void
    {
        $buildHelper = BuildHelper::getInstance();
        $buildHelper->createScenario('Security');

        $client = static::createBlackfiredHttpBrowserClient();

        $client->request('GET', '/security/login');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Sign in', [
            'email' => 'user+1@email.com',
            'password' => 'password',
        ]);

        $this->assertSelectorTextContains('body', 'Hello world');
    }
}
