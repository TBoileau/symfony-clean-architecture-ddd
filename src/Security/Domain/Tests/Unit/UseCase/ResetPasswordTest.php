<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Unit\UseCase;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Tests\Fixtures\Infrastructure\Repository\UserRepository;
use App\Security\Domain\Tests\Fixtures\Infrastructure\Security\PasswordHasher;
use App\Security\Domain\Tests\Fixtures\UserInterface\Input\ResetPasswordInput;
use App\Security\Domain\UseCase\ResetPassword\ResetPassword;
use App\Security\Domain\UseCase\ResetPassword\ResetPasswordInterface;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use Exception;
use PHPUnit\Framework\TestCase;

final class ResetPasswordTest extends TestCase
{
    private UserRepository $userRepository;

    private ResetPasswordInterface $useCase;

    private PasswordHasher $passwordHasher;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository([]);
        $this->passwordHasher = new PasswordHasher();
        $this->useCase = new ResetPassword($this->userRepository, $this->passwordHasher);
    }

    public function testIfResetPasswordIsSuccessful(): void
    {
        $user = User::create(
            identifier: UuidIdentifier::create(),
            email: EmailAddress::createFromString('user+1@email.com')
        );

        $user->requestForAForgottenPassword();
        $this->userRepository->users[] = $user;
        $input = new ResetPasswordInput('new_password', $user);
        $this->useCase->__invoke($input);

        $this->assertNull($user->forgottenPasswordRequestedAt);
        $this->assertNull($user->forgottenPasswordToken);

        /** @var HashedPassword $hashedPassword */
        $hashedPassword = $user->hashedPassword;

        $this->assertNotNull($hashedPassword);

        $this->assertTrue(
            $hashedPassword->verify(
                $this->passwordHasher,
                PlainPassword::createFromString('new_password')
            )
        );
        $this->assertFalse($user->canResetPassword());
    }

    public function testIfResetPasswordIsFailedBecauseUseHasNotRequestAForgottenPassword(): void
    {
        $user = User::create(
            identifier: UuidIdentifier::create(),
            email: EmailAddress::createFromString('user+2@email.com')
        );
        $this->userRepository->users[] = $user;
        $input = new ResetPasswordInput('new_password', $user);

        $this->expectException(Exception::class);
        $this->useCase->__invoke($input);
    }
}
