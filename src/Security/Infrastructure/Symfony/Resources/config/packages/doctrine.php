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

use App\Security\Infrastructure\Doctrine\Type\HashedPasswordType;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine): void {
    $doctrine->dbal()->type(HashedPasswordType::NAME)->class(HashedPasswordType::class);

    $doctrine->orm()
        ->entityManager('default')
            ->mapping('security')
                ->type('php')
                ->prefix('App\Security\Domain\Entity')
                ->dir(__DIR__.'/../../mapping')
                ->isBundle(false);
};
