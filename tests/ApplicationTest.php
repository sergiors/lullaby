<?php

namespace Sergiors\Lullaby\Tests;

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
        $this->assertEquals(true, $app->getContainer()->getParameter('debug'));
    }

    public function createApplication()
    {
        $app = new Application('dev', __DIR__, ['debug' => true]);
        $app['exception_handler']->disable();
        $app->boot();

        return $app;
    }
}
