<?php

namespace Sergiors\Lullaby\Controller;

use Silex\ControllerResolver as BaseControllerResolver;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class ControllerResolver extends BaseControllerResolver
{
    /**
     * {@inheritdoc}
     */
    protected function instantiateController($class)
    {
        $controller = parent::instantiateController($class);

        if (isset($this->app['di.container']) && $controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->app['di.container']);
        }

        return $controller;
    }
}
