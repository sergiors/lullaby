<?php

namespace Sergiors\Lullaby\Tests\Fixtures;

use Sergiors\Lullaby\Kernel;
use Sergiors\Lullaby\Tests\Fixtures\Apps\Test\Test;

class TestKernel extends Kernel
{
    public function __construct($environment, $debug, $rootDir = null)
    {
        parent::__construct($environment, $debug, $rootDir);
        
        $this['config.filenames'] = '%root_dir%/config_%environment%.yml';
    }

    public function registerApps()
    {
        return [
            new Test()
        ];
    }

    public function registerProviders()
    {
        return [];
    }
}
