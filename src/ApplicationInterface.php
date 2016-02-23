<?php

namespace Sergiors\Lullaby;

use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
interface ApplicationInterface
{
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
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer();

    /**
     * @param LoaderInterface $loader
     */
    public function registerConfiguration(LoaderInterface $loader);

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader);
}
