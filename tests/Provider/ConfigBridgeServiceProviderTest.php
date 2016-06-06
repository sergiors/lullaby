<?php

namespace Sergiors\Lullaby\Tests\Provider;

use Silex\Application;
use Sergiors\Silex\Provider\ConfigServiceProvider;
use Sergiors\Lullaby\Provider\ConfigBridgeServiceProvider;

class ConfigAdapterServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function register()
    {
        $app = $this->createApplication();
        $app->register(new ConfigServiceProvider());
        $app->register(new ConfigBridgeServiceProvider());
        $app['config.options'] = [
            'paths' => dirname(__DIR__).'/Fixture/app/config_dev.yml'
        ];

        $app['config.initializer']();
        $app['config.initializer']();

        $this->assertCount(1, $app['twig.options']);
        $this->assertCount(6, $app['db.options']);
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function shouldThrowLogicException()
    {
        $app = $this->createApplication();
        $app->register(new ConfigBridgeServiceProvider());
        $app['config.initializer']();
    }

    public function createApplication()
    {
        return new Application();
    }
}
