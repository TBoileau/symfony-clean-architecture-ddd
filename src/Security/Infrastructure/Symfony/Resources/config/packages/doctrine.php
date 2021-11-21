<?php

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
