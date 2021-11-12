<?php

declare(strict_types=1);

namespace App\Shared\Tests\Integration\Console;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class InMemoryDatabaseCreateCommandTest extends KernelTestCase
{
    public function testIfInMemoryDatabaseIsCreated(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('inmemory:database:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Database created !', $output);
    }
}
