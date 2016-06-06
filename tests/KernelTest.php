<?php

namespace Sergiors\Lullaby\Tests;

use Sergiors\Lullaby\Tests\Fixture\TestKernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function register()
    {
        $app = $this->createApplication();

        $this->assertCount(1, $app['twig.options']);
        $this->assertCount(6, $app['db.options']);

        $this->assertEquals('dev', $app['di.container']->getParameter('environment'));
        $this->assertTrue($app['di.container']->getParameter('debug'));
        $this->assertTrue($app->isDebug());
    }

    public function createApplication()
    {
        $app = new TestKernel('dev', true, __DIR__.'/Fixture/app');
        $app['config.options'] = [
            'paths' => '%root_dir%/config_%environment%.yml'
        ];
        $app->boot();

        return $app;
    }
}
