<?php

namespace Sergiors\Lullaby\Tests;

use Sergiors\Lullaby\Application as BaseApplication;
use Symfony\Component\Config\Loader\LoaderInterface;

class Application extends BaseApplication
{
    public function registerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/Fixture/app/config_'.$this->getEnvironment().'.yml');
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/Fixture/app/services.yml');
    }
}
