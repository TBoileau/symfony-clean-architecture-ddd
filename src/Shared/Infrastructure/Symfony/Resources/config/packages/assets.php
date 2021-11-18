<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework->assets()
        ->jsonManifestPath(sprintf('%s/public/build/manifest.json', param('kernel.project_dir')));
};
