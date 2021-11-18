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

namespace App\Shared\Domain\ValueObject\Uuid;

use Stringable;
use Symfony\Component\Uid\Uuid;

abstract class AbstractUuid implements Stringable
{
    protected function __construct(private Uuid $uuid)
    {
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    abstract public static function create(): AbstractUuid;

    abstract public static function createFromString(string $uuid): AbstractUuid;

    abstract public static function createFromUuid(Uuid $uuid): AbstractUuid;

    public function uuid(): Uuid
    {
        return $this->uuid;
    }
}
