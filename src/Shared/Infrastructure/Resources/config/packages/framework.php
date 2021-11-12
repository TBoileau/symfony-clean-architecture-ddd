<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework
        ->secret(env('APP_SECRET'))
        ->httpMethodOverride(false);

    $framework->phpErrors()
        ->log(true);

    $framework->session()
        ->handlerId('session.handler.native_file')
        ->cookieSecure('auto')
        ->cookieSamesite('lax')
        ->savePath(
            sprintf(
                '%s/var/sessions/%s',
                param('kernel.project_dir'),
                param('kernel.environment')
            )
        );
};
