<?php

namespace Sergiors\Lullaby\Tests\Provider;

use Silex\Provider\TwigServiceProvider;
use Sergiors\Lullaby\Tests\Fixtures\TestKernel;
use Sergiors\Lullaby\Provider\TwigBridgeServiceProvider;

class TwigBridgeServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function register()
    {
        $app = $this->createApplication();
        $app->register(new TwigServiceProvider());
        $app->register(new TwigBridgeServiceProvider());

        $this->assertCount(1, $app['twig.loader.filesystem']->getPaths('Test'));
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function shouldThrowLogicException()
    {
        $app = $this->createApplication();
        $app->register(new TwigBridgeServiceProvider());
    }

    public function createApplication()
    {
        $app = new TestKernel('dev', true, dirname(__DIR__).'/Fixtures/app');

        return $app;
    }
}
