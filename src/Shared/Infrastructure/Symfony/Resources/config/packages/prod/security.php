<?php

declare(strict_types=1);

use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $security): void {
    $security->firewall('main')
        ->loginThrottling()
            ->maxAttempts(3)
            ->interval('15 minutes');
};
