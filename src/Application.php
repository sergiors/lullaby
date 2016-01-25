<?php

namespace Sergiors\Lullaby;

use Silex\Application as BaseApplication;
use Symfony\Component\Config\Loader\LoaderInterface;
use Sergiors\Silex\Provider\ConfigServiceProvider;
use Sergiors\Silex\Provider\DependencyInjectionServiceProvider;

/**
 * @author Sérgio Rafael Siquira <sergio@inbep.com.br>
 */
abstract class Application extends BaseApplication
{
    const LULLABY_VERSION = '1.1.0-DEV';

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @param string $environment
     * @param string $rootDir
     * @param array  $values|[]
     */
    public function __construct($environment, $rootDir, array $values = [])
    {
        parent::__construct($values);

        $this->environment = $environment;
        $this->rootDir = $rootDir;

        $this['resolver'] = $this->share(function (Application $app) {
            return new ControllerResolver($app, $app['logger']);
        });

        $this->register(new DependencyInjectionServiceProvider());
        $this->register(new ConfigServiceProvider(), [
            'config.replacements' => [
                'root_dir' => $this->rootDir,
            ],
        ]);
    }

    public function getRootDir()
    {
        return $this['config.parameters']->get('root_dir');
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function boot()
    {
        $this->registerConfiguration($this['config.loader']);
        $this->registerServices($this['di.loader']);

        parent::boot();
    }

    /**
     * @param LoaderInterface $loader
     */
    abstract protected function registerConfiguration(LoaderInterface $loader);

    /**
     * @param LoaderInterface $loader
     */
    abstract protected function registerServices(LoaderInterface $loader);
}
