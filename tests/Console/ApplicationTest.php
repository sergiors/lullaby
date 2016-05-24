<?php

namespace Sergiors\Lullaby\Console;

use Sergiors\Lullaby\Console\Application as ConsoleApplication;
use Sergiors\Lullaby\Tests\Fixture\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registerContainer()
    {
        $app = $this->createApplication();
        $app['console'] = function () use ($app) {
            return new ConsoleApplication($app);
        };

        $this->assertEquals('Lullaby', $app['console']->getName());
    }

    public function createApplication()
    {
        $app = new Application('dev', dirname(__DIR__), ['debug' => true]);
        $app->boot();

        return $app;
    }
}
