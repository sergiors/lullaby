<?php

namespace Sergiors\Lullaby\Tests\Provider;

use Silex\Application;
use Sergiors\Silex\Provider\DependencyInjectionServiceProvider;
use Sergiors\Lullaby\Provider\DependencyInjectionBridgeServiceProvider;

class DependencyInjectionAdapterServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function register()
    {
        $app = $this->createApplication();
        $app->register(new DependencyInjectionServiceProvider());
        $app->register(new DependencyInjectionBridgeServiceProvider());
        $app['di.options'] = [
            'paths' => '%root_dir%/services.yml'
        ];
        $app['di.parameters'] = [
            'root_dir' => dirname(__DIR__).'/Fixture/app'
        ];

        $app['di.initializer']();
        $app['di.initializer']();


        $this->assertCount(2, $app['di.container']->getServiceIds());
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function shouldThrowLogicException()
    {
        $app = $this->createApplication();
        $app->register(new DependencyInjectionBridgeServiceProvider());
        $app['di.initializer']();
    }

    public function createApplication()
    {
        return new Application();
    }
}
