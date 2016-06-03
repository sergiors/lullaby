<?php

namespace Sergiors\Lullaby\Console;

use Sergiors\Lullaby\Console\Application as ConsoleApplication;
use Sergiors\Lullaby\Tests\Fixture\TestKernel;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registerContainer()
    {
        $app = $this->createApplication();
        $app['console'] = $app->share(function () use ($app) {
            return new ConsoleApplication($app);
        });

        $this->assertEquals('Lullaby', $app['console']->getName());
    }

    public function createApplication()
    {
        $app = new TestKernel('dev', dirname(__DIR__).'/Fixture');
        $app->boot();

        return $app;
    }
}
