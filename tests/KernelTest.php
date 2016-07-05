<?php

namespace Sergiors\Lullaby\Tests;

use Sergiors\Lullaby\Tests\Fixture\TestKernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldLoadYamlToContainer()
    {
        $app = new TestKernel('dev', true, __DIR__.'/Fixture/app');
        $app['config.options'] = [
            'paths' => '%root_dir%/config_%environment%.yml'
        ];
        $app->boot();

        $this->assertCount(1, $app['twig.options']);
        $this->assertCount(6, $app['db.options']);

        $this->assertEquals('dev', $app['di.container']->getParameter('environment'));
        $this->assertTrue($app['di.container']->getParameter('debug'));
        $this->assertTrue($app['debug']);
        $this->assertEquals('dev', $app['environment']);
        $this->assertEquals(__DIR__.'/Fixture/app/cache/dev/proxy', $app['orm.proxy_dir']);
    }

    /**
     * @test
     */
    public function shouldReturnTotalApps()
    {
        $app = new TestKernel('dev', true, __DIR__.'/Fixture/app');
        $app->boot();

        $this->assertCount(1, $app['apps']);
    }
}
