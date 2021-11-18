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
