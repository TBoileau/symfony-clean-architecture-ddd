<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

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
        $contents = require $this->getProjectDir().'/src/Shared/Infrastructure/Resources/config/bundles.php';

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
        $container->import(__DIR__.'/../../**/Infrastructure/Resources/config/packages/*.php');
        $container->import(__DIR__.'/../../**/Infrastructure/Resources/config/packages/'.$this->environment.'/*.php');
        $container->import(__DIR__.'/../../**/Infrastructure/Resources/config/{services}.php');
        $container->import(__DIR__.'/../../**/Infrastructure/Resources/config/{services}.php');
        $container->import(__DIR__.'/../../**/Infrastructure/Resources/config/{services}'.$this->environment.'.php');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__.'/../../**/Infrastructure/Resources/config/{routes}/'.$this->environment.'/*.php');
        $routes->import(__DIR__.'/../../**/Infrastructure/Resources/config/{routes}/*.php');
        $routes->import(__DIR__.'/../../**/Infrastructure/Resources/config/routes.php');
        $routes->import(__DIR__.'/../../**/Infrastructure/Resources/config/{routes}_'.$this->environment.'.php');
    }
}
