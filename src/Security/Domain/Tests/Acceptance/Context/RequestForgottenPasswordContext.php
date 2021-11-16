<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Acceptance\Context;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Tests\Fixtures\Infrastructure\Repository\UserRepository;
use App\Security\Domain\Tests\Fixtures\UserInterface\Input\RequestForgottenPasswordInput;
use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPassword;
use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Date\DateTime;
use App\Shared\Domain\ValueObject\Date\Interval;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

final class RequestForgottenPasswordContext implements Context
{
    private User $registeredUser;

    private string $email;

    /**
     * @Given /^I registered with my email address (.+)$/
     */
    public function iRegisteredWithMyEmailAddress(string $email): void
    {
        $this->registeredUser = User::create(
            identifier: UuidIdentifier::create(),
            email: EmailAddress::createFromString($email)
        );
    }

    /**
     * @Given /^I have already request a forgotten password (\d+) hours ago$/
     */
    public function iHaveAlreadyRequestAForgottenPasswordHoursAgo(int $hours): void
    {
        $this->registeredUser->requestForAForgottenPassword();
        /** @var DateTime $forgottenPasswordRequestedAt */
        $forgottenPasswordRequestedAt = $this->registeredUser->forgottenPasswordRequestedAt;
        $this->registeredUser->forgottenPasswordRequestedAt = $forgottenPasswordRequestedAt->sub(
            Interval::createFromString(
                sprintf('PT%dH', $hours)
            )
        );
    }

    /**
     * @When /^I request a forgotten password with (.+)$/
     */
    public function iRequestAForgottenPasswordWith(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @Then /^then I can use my forgotten password token for the next 24 hours$/
     */
    public function thenICanUseMyForgottenPasswordTokenForTheNextHours(): void
    {
        $userGateway = new UserRepository([$this->registeredUser]);

        $useCase = new RequestForgottenPassword($userGateway);

        $useCase(new RequestForgottenPasswordInput($this->email));

        Assert::assertNotNull($this->registeredUser->forgottenPasswordRequestedAt);
        Assert::assertNotNull($this->registeredUser->forgottenPasswordToken);
        Assert::assertTrue($this->registeredUser->canResetPassword());
    }

    /**
     * @Then /^I get an error that tells me "(.+)"/
     */
    public function iGetAnErrorThatMyEmailDoesNotExist(string $errorMessage): void
    {
        $userGateway = new UserRepository([$this->registeredUser]);

        $useCase = new RequestForgottenPassword($userGateway);

        try {
            $useCase(new RequestForgottenPasswordInput($this->email));
        } catch (InvalidArgumentException $exception) {
            Assert::assertEquals($errorMessage, $exception->getMessage());
        }
    }
}
