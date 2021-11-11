<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework
        ->secret(env('APP_SECRET'))
        ->httpMethodOverride(false);

    $framework->phpErrors()
            ->log(true);

    $framework->session()
            ->handlerId(null)
            ->cookieSecure('auto')
            ->cookieSamesite('lax')
            ->storageFactoryId('session.storage.factory.native');
};
