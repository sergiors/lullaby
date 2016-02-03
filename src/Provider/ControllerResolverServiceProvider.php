<?php

namespace Sergiors\Lullaby\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Sergiors\Lullaby\Controller\ControllerResolver;

/**
 * @author Sérgio Rafael Siquira <sergio@inbep.com.br>
 */
class ControllerResolverServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['resolver'] = $app->share(function (Application $app) {
            return new ControllerResolver($app, $app['logger']);
        });
    }

    public function boot(Application $app)
    {
    }
}
