<?php

namespace Sergiors\Lullaby;

use Silex\Application as BaseApplication;
use Sergiors\Lullaby\Provider\ControllerResolverServiceProvider;
use Sergiors\Silex\Provider\ConfigServiceProvider;
use Sergiors\Silex\Provider\DependencyInjectionServiceProvider;

/**
 * @author Sérgio Rafael Siquira <sergio@inbep.com.br>
 */
abstract class Application extends BaseApplication implements ApplicationInterface
{
    const LULLABY_VERSION = '1.1.0-DEV';

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var string
     */
    protected $cacheDir;

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
        $this->cacheDir = $this->getCacheDir();
        $this->debug = (bool) $this['debug'];

        $this->register(new ConfigServiceProvider());
        $this->register(new DependencyInjectionServiceProvider());
        $this->register(new ControllerResolverServiceProvider());

        $this['config.replacements'] = $this['di.parameters'] = [
            'root_dir' => $this->rootDir,
            'environment' => $this->environment,
            'debug' => $this->debug,
            'cache_dir' => $this->cacheDir
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->rootDir.'/cache/'.$this->environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer()
    {
        return $this['di.container'];
    }

    public function boot()
    {
        $this->registerConfiguration($this['config.loader']);
        $this->registerContainerConfiguration($this['di.loader']);

        parent::boot();
    }
}
