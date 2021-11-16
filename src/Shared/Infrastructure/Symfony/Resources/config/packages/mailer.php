<?php

declare(strict_types=1);

use Symfony\Config\Framework\MailerConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return function (MailerConfig $mailer) {
    $mailer->dsn(env('MAILER_DSN'));
};
