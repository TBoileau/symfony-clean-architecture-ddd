<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Acceptance\Context;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Tests\Fixtures\Infrastructure\Repository\UserRepository;
use App\Security\Domain\Tests\Fixtures\Infrastructure\Security\PasswordHasher;
use App\Security\Domain\Tests\Fixtures\UserInterface\Input\RequestForgottenPasswordInput;
use App\Security\Domain\Tests\Fixtures\UserInterface\Input\ResetPasswordInput;
use App\Security\Domain\Tests\Fixtures\UserInterface\Presenter\RequestForgottenPasswordPresenter;
use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPassword;
use App\Security\Domain\UseCase\ResetPassword\ResetPassword;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Date\DateTime;
use App\Shared\Domain\ValueObject\Date\Interval;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

final class SecurityContext implements Context
{
    private User $registeredUser;

    private string $email;

    private string $plainPassword;

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
     * @Given /^I request a forgotten password$/
     */
    public function iRequestAForgottenPassword(): void
    {
        $this->registeredUser->requestForAForgottenPassword();
    }

    /**
     * @When /^I reset my password with (.+)/
     */
    public function iResetMyPasswordWith(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @When /^I request a forgotten password with (.+)$/
     */
    public function iRequestAForgottenPasswordWith(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @Then /^I can use my forgotten password token for the next 24 hours$/
     */
    public function thenICanUseMyForgottenPasswordTokenForTheNextHours(): void
    {
        $userGateway = new UserRepository([$this->registeredUser]);

        $useCase = new RequestForgottenPassword($userGateway);

        $useCase(new RequestForgottenPasswordInput($this->email), new RequestForgottenPasswordPresenter());

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
            $useCase(new RequestForgottenPasswordInput($this->email), new RequestForgottenPasswordPresenter());
        } catch (InvalidArgumentException $exception) {
            Assert::assertEquals($errorMessage, $exception->getMessage());
        }
    }

    /**
     * @Then /^My password is reset and I can log in again$/
     */
    public function myPasswordIsResetAndICanLogInAgain(): void
    {
        $userGateway = new UserRepository([$this->registeredUser]);

        $passwordHasher = new PasswordHasher();

        $useCase = new ResetPassword($userGateway, $passwordHasher);

        $useCase(new ResetPasswordInput($this->plainPassword, $this->registeredUser));

        Assert::assertNull($this->registeredUser->forgottenPasswordRequestedAt);
        Assert::assertNull($this->registeredUser->forgottenPasswordToken);
        Assert::assertNull($this->registeredUser->plainPassword);
        Assert::assertFalse($this->registeredUser->canResetPassword());

        /** @var HashedPassword $hashedPassword */
        $hashedPassword = $this->registeredUser->hashedPassword;
        Assert::assertTrue(
            $hashedPassword->verify(
                $passwordHasher,
                PlainPassword::createFromString($this->plainPassword)
            )
        );
    }
}
