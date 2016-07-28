<?php

namespace Sergiors\Lullaby;

use Silex\Application;
use Sergiors\Silex\Provider\ConfigServiceProvider;
use Sergiors\Lullaby\Application\ApplicationInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
abstract class Kernel extends Application implements KernelInterface
{
    const LULLABY_VERSION = '3.0.0-dev';

    /**
     * @var ApplicationInterface[]
     */
    protected $apps = [];

    /**
     * @param array        $env
     * @param bool         $debug
     * @param string|null  $rootDir
     */
    public function __construct($env, $debug = false, $rootDir = null)
    {
        $rootDir = $rootDir ?: $this->getRootDir();
        $params = [
            'env' => $env,
            'root_dir' => $rootDir,
            'cache_dir' => $rootDir.'/cache/'.$env,
            'debug' => $debug
        ];

        parent::__construct($params);

        $this->register(new ConfigServiceProvider(), [
            'config.replacements' => $params
        ]);

        $this->initializeApps();
        $this->initializeProviders();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->initializeConfig();

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

    protected function initializeConfig()
    {
        $this['config.initializer']();
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
