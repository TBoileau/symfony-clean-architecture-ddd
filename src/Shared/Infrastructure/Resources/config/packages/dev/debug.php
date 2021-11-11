<?php

declare(strict_types=1);

use Symfony\Config\DebugConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (DebugConfig $debugConfig): void {
    $debugConfig->dumpDestination(sprintf('tcp://%s', env('VAR_DUMPER_SERVER')));
};
