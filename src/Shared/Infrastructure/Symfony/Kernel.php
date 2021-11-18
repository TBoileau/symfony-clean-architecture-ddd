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

namespace App\Shared\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return iterable<BundleInterface>
     */
    public function registerBundles(): iterable
    {
        /** @var array<class-string, array<string, bool>> $contents */
        $contents = require $this->getProjectDir().'/src/Shared/Infrastructure/Symfony/Resources/config/bundles.php';

        /**
         * @var class-string        $class
         * @var array<string, bool> $envs
         */
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                /** @var BundleInterface $bundle */
                $bundle = new $class();
                yield $bundle;
            }
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->configDir().'/packages/*.php');
        $container->import($this->configDir().'/packages/'.$this->environment.'/*.php');
        $container->import($this->configDir().'/{services}.php');
        $container->import($this->configDir().'/{services}.php');
        $container->import($this->configDir().'/{services}'.$this->environment.'.php');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->configDir().'/{routes}/'.$this->environment.'/*.php');
        $routes->import($this->configDir().'/{routes}/*.php');
        $routes->import($this->configDir().'/routes.php');
        $routes->import($this->configDir().'/{routes}_'.$this->environment.'.php');
    }

    private function configDir(): string
    {
        return $this->getProjectDir().'/src/**/Infrastructure/Symfony/Resources/config';
    }
}
