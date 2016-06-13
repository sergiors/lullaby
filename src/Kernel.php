<?php

namespace Sergiors\Lullaby;

use Silex\Application;
use Sergiors\Lullaby\Provider\ControllerResolverServiceProvider;
use Sergiors\Silex\Provider\ConfigServiceProvider;
use Sergiors\Silex\Provider\DependencyInjectionServiceProvider;
use Sergiors\Lullaby\Application\ApplicationInterface;
use Sergiors\Lullaby\Provider\ConfigBridgeServiceProvider;
use Sergiors\Lullaby\Provider\DependencyInjectionBridgeServiceProvider;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
abstract class Kernel extends Application implements KernelInterface
{
    const LULLABY_VERSION = '2.1.0-dev';

    /**
     * @var ApplicationInterface[]
     */
    protected $apps = [];

    /**
     * @param array        $environment
     * @param bool         $debug
     * @param string|null  $rootDir
     */
    public function __construct($environment, $debug = false, $rootDir = null)
    {
        $rootDir = $rootDir ?: $this->getRootDir();

        parent::__construct($params = [
            'environment' => $environment,
            'root_dir' => $rootDir,
            'cache_dir' => $rootDir.'/cache/'.$environment,
            'debug' => $debug
        ]);

        $this->register(new ConfigServiceProvider());
        $this->register(new DependencyInjectionServiceProvider());
        $this->register(new ControllerResolverServiceProvider());
        $this->register(new ConfigBridgeServiceProvider());
        $this->register(new DependencyInjectionBridgeServiceProvider());

        $this->initializeProviders();

        $this['config.replacements'] = $this['di.parameters'] = $params;
    }
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->initializeConfiguration();
        $this->initializeApps();

        foreach ($this->apps as $app) {
            $app->boot($this);
        }

        parent::boot();
    }

    protected function getRootDir()
    {
        if (!isset($this['root_dir'])) {
            $reflObject = new \ReflectionObject($this);
            $this['root_dir'] = dirname($reflObject->getFileName());
        }

        return $this['root_dir'];
    }

    protected function initializeConfiguration()
    {
        $this['config.initializer']();
        $this['di.initializer']();
    }

    protected function initializeApps()
    {
        $this->apps = array_reduce($this->registerApps(), function ($apps, ApplicationInterface $app) {
            $apps[$app->getName()] = $app;
            return $apps;
        }, []);

        $this['apps'] = array_map(function (ApplicationInterface $app) {
            return get_class($app);
        }, $this->apps);
    }

    protected function initializeProviders()
    {
        $providers = $this->registerProviders();

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }
}
