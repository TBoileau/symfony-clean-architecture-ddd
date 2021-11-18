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

namespace App\Shared\Domain\ValueObject\Date;

use App\Shared\Domain\Exception\InvalidArgumentException;
use DateInterval;
use Exception;

final class Interval
{
    private function __construct(public string $interval)
    {
    }

    public function __toString(): string
    {
        return $this->interval;
    }

    public static function createFromString(string $interval): Interval
    {
        try {
            new DateInterval($interval);
        } catch (Exception) {
            throw new InvalidArgumentException('Interval invalid.');
        }

        return new Interval($interval);
    }

    public function toDateInterval(): DateInterval
    {
        return new DateInterval($this->interval);
    }
}
