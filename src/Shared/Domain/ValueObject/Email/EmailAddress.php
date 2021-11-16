<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Email;

use App\Shared\Domain\Exception\InvalidArgumentException;
use Stringable;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validation;

class EmailAddress implements Stringable
{
    private function __construct(private string $email)
    {
        if (Validation::createValidator()->validate($this->email, [new Email()])->count() > 0) {
            throw new InvalidArgumentException(sprintf('%s is not a valid email', $this->email));
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public static function createFromString(string $email): EmailAddress
    {
        return new EmailAddress($email);
    }

    public function equalTo(EmailAddress $email): bool
    {
        return (string) $email === (string) $this;
    }
}
