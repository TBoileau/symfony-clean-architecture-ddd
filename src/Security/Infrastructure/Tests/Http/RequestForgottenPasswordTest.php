<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tests\Http;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequestForgottenPasswordTest extends WebTestCase
{
    public function testIfRequestForgottenPasswordIsSuccessfulAndSendEmail(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/security/request-forgotten-password');

        $client->submitForm('Request', [
            'request_forgotten_password[email]' => 'user+1@email.com',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertEmailCount(1);

        /** @var UserGateway<User> $userGateway */
        $userGateway = $client->getContainer()->get(UserGateway::class);

        /** @var User $user */
        $user = $userGateway->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));

        $this->assertNotNull($user->forgottenPasswordToken);
        $this->assertNotNull($user->forgottenPasswordRequestedAt);
        $this->assertTrue($user->canResetPassword());
    }

    /**
     * @dataProvider provideFailedEmail
     */
    public function testIfRequestForgottenPasswordIsFailed(string $email): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/security/request-forgotten-password');

        $client->submitForm('Request', [
            'request_forgotten_password[email]' => $email,
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @return iterable<string, array<array-key, string>>
     */
    public function provideFailedEmail(): iterable
    {
        yield 'empty email' => [''];
        yield 'inavlid email' => ['fail'];
    }

    public function testIfRequestForgottenPasswordIsFailedBecauseNonExistingEmail(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/security/request-forgotten-password');

        $crawler = $client->submitForm('Request', [
            'request_forgotten_password[email]' => 'user+0@email.com',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertStringContainsString(
            'This email does not exist.',
            $crawler->filter('form[name=request_forgotten_password]')->text()
        );
    }

    public function testIfRequestForgottenPasswordIsFailedBecauseForgottenPasswordHasAlreadyBeenRequested(): void
    {
        $client = static::createClient();

        /** @var UserGateway<User> $userGateway */
        $userGateway = $client->getContainer()->get(UserGateway::class);

        /** @var User $user */
        $user = $userGateway->getUserByEmail(EmailAddress::createFromString('user+1@email.com'));
        $user->requestForAForgottenPassword();
        $userGateway->update($user);

        $client->request(Request::METHOD_GET, '/security/request-forgotten-password');

        $crawler = $client->submitForm('Request', [
            'request_forgotten_password[email]' => 'user+1@email.com',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertStringContainsString(
            'You have already request for a forgotten password last 24 hours.',
            $crawler->filter('form[name=request_forgotten_password]')->text()
        );
    }
}
