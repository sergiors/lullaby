<?php

namespace Sergiors\Lullaby\Tests\Fixtures;

use Sergiors\Lullaby\Kernel;
use Sergiors\Lullaby\Tests\Fixtures\Apps\Test\Test;

class TestKernel extends Kernel
{
    public function __construct($env, $debug, $rootDir = null, $varDir = null)
    {
        parent::__construct($env, $debug, $rootDir, $varDir);

        $this['config.filenames'] = '%root_dir%/config_%env%.yml';
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
