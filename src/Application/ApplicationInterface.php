<?php

namespace Sergiors\Lullaby\Application;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
interface ApplicationInterface
{
    /**
     * @param \Silex\Application $app
     */
    public function boot(\Silex\Application $app);

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getName();
}
