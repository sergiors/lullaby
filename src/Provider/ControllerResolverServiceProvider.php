<?php

namespace Sergiors\Lullaby\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Sergiors\Lullaby\Controller\ControllerResolver;

/**
 * @author Sérgio Rafael Siquira <sergio@inbep.com.br>
 */
class ControllerResolverServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['resolver'] = function () use ($app) {
            return new ControllerResolver($app, $app['logger']);
        };
    }
}
