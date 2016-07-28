<?php

namespace Sergiors\Lullaby\Tests\Fixtures;

use Sergiors\Lullaby\Kernel;
use Sergiors\Lullaby\Tests\Fixtures\Apps\Test\Test;

class TestKernel extends Kernel
{
    public function __construct($environment, $debug, $rootDir = null)
    {
        $this['config.filenames'] = '%root_dir%/config_%environment%.yml';

        parent::__construct($environment, $debug, $rootDir);
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
