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

use Stringable;

interface DateTimeInterface extends Stringable
{
    public static function createFromDateTime(\DateTimeInterface $dateTime): DateTimeInterface;

    public static function createFromString(string $dateTime): DateTimeInterface;

    public static function now(): DateTimeInterface;

    public function toDateTime(): \DateTimeInterface;

    public function isEarlierThan(DateTimeInterface $date): bool;

    public function isLaterThan(DateTimeInterface $date): bool;

    public function add(Interval $interval): DateTimeInterface;

    public function sub(Interval $interval): DateTimeInterface;
}
