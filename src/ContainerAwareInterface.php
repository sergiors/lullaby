<?php

namespace Sergiors\Lullaby;

use Pimple\Container;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
interface ContainerAwareInterface
{
    /**
     * @param Container $app
     */
    public function setContainer(Container $app);
}
