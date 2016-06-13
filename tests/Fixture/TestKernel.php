<?php

namespace Sergiors\Lullaby\Tests\Fixture;

use Sergiors\Lullaby\Kernel;
use Sergiors\Lullaby\Tests\Fixture\Apps\Test\Test;

class TestKernel extends Kernel
{
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
