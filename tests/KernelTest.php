<?php

namespace Sergiors\Lullaby\Tests;

use Sergiors\Lullaby\Tests\Fixtures\TestKernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldLoadYamlToContainer()
    {
        $app = new TestKernel('dev', true, __DIR__.'/Fixtures/app');
        $app->boot();

        $this->assertCount(1, $app['twig.options']);
        $this->assertCount(6, $app['db.options']);

        $this->assertTrue($app['debug']);
        $this->assertEquals('dev', $app['environment']);
    }

    /**
     * @test
     */
    public function shouldReturnTotalApps()
    {
        $app = new TestKernel('dev', true, __DIR__.'/Fixtures/app');

        $this->assertCount(1, $app['apps']);
    }
}
