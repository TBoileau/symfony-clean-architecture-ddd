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

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use Symfony\Config\WebpackEncoreConfig;

return static function (WebpackEncoreConfig $webpackEncore): void {
    $webpackEncore
        ->outputPath(sprintf('%s/public/build', param('kernel.project_dir')))
        ->scriptAttributes('defer', true);
};
