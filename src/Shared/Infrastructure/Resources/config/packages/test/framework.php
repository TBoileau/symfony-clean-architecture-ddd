<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (FrameworkConfig $frameworkConfig): void {
    $frameworkConfig->test(true)->session()->storageFactoryId('session.storage.factory.mock_file');
    $frameworkConfig->profiler()->collect(false);
};
