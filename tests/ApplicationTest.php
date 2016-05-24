<?php

namespace Sergiors\Lullaby\Tests;

use Sergiors\Lullaby\Tests\Fixture\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function register()
    {
        $app = $this->createApplication();

        $this->assertCount(1, $app['twig.options']);
        $this->assertCount(6, $app['db.options']);

        $this->assertEquals('dev', $app->getContainer()->getParameter('environment'));
        $this->assertTrue($app->getContainer()->getParameter('debug'));
        $this->assertTrue($app->isDebug());
    }

    public function createApplication()
    {
        $app = new Application('dev', __DIR__, ['debug' => 1]);
        $app->boot();

        return $app;
    }
}
