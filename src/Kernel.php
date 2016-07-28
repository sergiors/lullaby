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
     * @param array        $environment
     * @param bool         $debug
     * @param string|null  $rootDir
     */
    public function __construct($environment, $debug = false, $rootDir = null)
    {
        $rootDir = $rootDir ?: $this->getRootDir();
        $replacements = [
            'environment' => $environment,
            'root_dir' => $rootDir,
            'cache_dir' => $rootDir.'/cache/'.$environment,
            'debug' => $debug
        ];

        parent::__construct(array_merge($replacements, [
            'config.replacements' => $replacements
        ]));

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

    final protected function initializeConfig()
    {
        $this['config.initializer']();
    }

    final protected function initializeApps()
    {
        $this->apps = array_reduce($this->registerApps(), function ($apps, ApplicationInterface $app) {
            $apps[$app->getName()] = $app;

            return $apps;
        }, []);

        $this['apps'] = array_map(function (ApplicationInterface $app) {
            return get_class($app);
        }, $this->apps);
    }

    final protected function initializeProviders()
    {
        $providers = array_merge([new ConfigServiceProvider()], $this->registerProviders());

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }
}
