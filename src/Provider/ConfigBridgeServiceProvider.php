<?php

namespace Sergiors\Lullaby\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class ConfigBridgeServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if (!isset($app['config.loader'])) {
            throw new \LogicException(
                'You must register the ConfigServiceProvider to use the ConfigAdapterServiceProvider.'
            );
        }

        $app['config.initializer'] = $app->protect(function () use ($app) {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            $paths = (array) $app['config.options']['paths'];
            foreach ($paths as $path) {
                $path = $app['config.parameters']->resolveValue($path);
                $app['config.loader']->load($path);
            }
        });

        $app['config.options'] = [
            'paths' => []
        ];
    }

    public function boot(Application $app)
    {
    }
}
