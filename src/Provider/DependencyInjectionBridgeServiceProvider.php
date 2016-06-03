<?php

namespace Sergiors\Lullaby\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class DependencyInjectionBridgeServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if (!isset($app['di.loader'])) {
            throw new \LogicException(
                'You must register the DependencyInjectionServiceProvider to use the DependencyInjectionAdapterServiceProvider.'
            );
        }

        $app['di.initializer'] = $app->protect(function () use ($app) {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            $paths = (array) $app['di.options']['paths'];
            foreach ($paths as $path) {
                $path = $app['di.container']->getParameterBag()->resolveValue($path);
                $app['di.loader']->load($path);
            }
        });

        $app['di.options'] = [
            'paths' => []
        ];
    }

    public function boot(Application $app)
    {
    }
}
