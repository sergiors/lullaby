<?php

namespace Sergiors\Lullaby\Application;

use Pimple\Container;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
interface ApplicationInterface
{
    /**
     * @param Container $app
     */
    public function boot(Container $app);

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
