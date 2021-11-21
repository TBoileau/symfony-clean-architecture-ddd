<?php

declare(strict_types=1);

use Symfony\Config\WebProfilerConfig;

return static function (WebProfilerConfig $webProfilerConfig): void {
    $webProfilerConfig->toolbar(false)->interceptRedirects(false);
};
