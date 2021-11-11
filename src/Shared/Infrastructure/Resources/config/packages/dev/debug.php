<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Config\DebugConfig;

return static function (DebugConfig $debugConfig): void {
    $debugConfig->dumpDestination(sprintf('tcp://%s', env('VAR_DUMPER_SERVER')));
};
