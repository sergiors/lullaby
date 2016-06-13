<?php

namespace Sergiors\Lullaby;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
interface KernelInterface
{
    /**
     * @return \Sergiors\Lullaby\Application\ApplicationInterface[]
     */
    public function registerApps();

    /**
     * @return \Pimple\ServiceProviderInterface[]
     */
    public function registerProviders();
}
