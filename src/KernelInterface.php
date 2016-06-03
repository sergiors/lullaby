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
     * @return string
     */
    public function getEnvironment();

    /**
     * @return bool
     */
    public function isDebug();

    /**
     * @return string
     */
    public function getRootDir();

    /**
     * @return string
     */
    public function getCacheDir();

    /**
     * @return array
     */
    public function getApps();
}
