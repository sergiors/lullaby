<?php

namespace Sergiors\Lullaby\Provider;

use Sergiors\Lullaby\Controller\ControllerResolver;
use Silex\Application;
use Silex\ServiceProviderInterface;

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
