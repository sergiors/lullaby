<?php

namespace Sergiors\Lullaby\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class TwigBridgeServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if (!isset($app['twig'])) {
            throw new \LogicException(
                'You must register the TwigServiceProvider to use the TwigAdapterServiceProvider.'
            );
        }

        $app['twig.loader.filesystem'] = $app->share(
            $app->extend('twig.loader.filesystem', function (\Twig_Loader_Filesystem $loader) use ($app) {
                foreach ($app['apps'] as $namespace => $class) {
                    $path = $app['root_dir'].'/Resources/'.$namespace.'/views';
                    if (is_dir($path)) {
                        $loader->addPath($path, $namespace);
                    }

                    $reflClass = new \ReflectionClass($class);
                    $path = dirname($reflClass->getFileName()).'/Resources/views';
                    
                    if (is_dir($path)) {
                        $loader->addPath($path, $namespace);
                    }
                }

                return $loader;
            })
        );
    }

    public function boot(Application $app)
    {
    }
}
