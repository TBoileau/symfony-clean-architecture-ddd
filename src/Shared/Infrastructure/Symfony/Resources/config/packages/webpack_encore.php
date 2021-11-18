<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use Symfony\Config\WebpackEncoreConfig;

return static function (WebpackEncoreConfig $webpackEncore): void {
    $webpackEncore
        ->outputPath(sprintf('%s/public/build', param('kernel.project_dir')))
        ->scriptAttributes('defer', true);
};
