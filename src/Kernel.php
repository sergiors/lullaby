<?php

namespace Sergiors\Lullaby;

use Silex\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use Sergiors\Lullaby\Config\Loader\YamlFileLoader;
use Sergiors\Lullaby\Config\Loader\PhpFileLoader;
use Sergiors\Lullaby\Config\Loader\DirectoryLoader;
use Sergiors\Lullaby\Application\ApplicationInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
abstract class Kernel extends Application implements KernelInterface
{
    const LULLABY_VERSION = '3.0.0-dev';

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @var ApplicationInterface[]
     */
    protected $apps = [];

    /**
     * @param array        $env
     * @param bool         $debug
     * @param string|null  $rootDir
     * @param string|null  $varDir
     */
    public function __construct($env, $debug = false, $rootDir = null, $varDir = null)
    {
        $rootDir = $rootDir ?: $this->getRootDir();
        $varDir = $varDir ?: $rootDir;

        parent::__construct($params = [
            'env' => $env,
            'root_dir' => $rootDir,
            'cache_dir' => $varDir.'/cache/'.$env,
            'log_dir' => $varDir.'/logs/'.$env,
            'debug' => $debug,
        ]);

        $this['config.filenames'] = [];
        $this['config.replacements'] = $params;

        $this->initializeApps();
        $this->initializeProviders();
    }

    /**
     * Load configuration and boot the applications
     *
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

    /**
     * @return string
     */
    protected function getRootDir()
    {
        if (!isset($this['root_dir'])) {
            $reflObject = new \ReflectionObject($this);
            $this['root_dir'] = dirname($reflObject->getFileName());
        }

        return realpath($this['root_dir']) ?: $this['root_dir'];
    }

    private function initializeConfig()
    {
        if ($this->loaded) {
            return;
        }

        $this->loaded = true;

        if ([] === $filenames = (array) $this['config.filenames']) {
            return;
        }

        $parameterBag = new EnvPlaceholderParameterBag($this['config.replacements']);
        $locator = new FileLocator();
        $loaders = [
            new PhpFileLoader($this, $locator),
            new DirectoryLoader($locator),
        ];

        if (class_exists('Symfony\\Component\\Yaml\\Yaml')) {
            $loaders[] = new YamlFileLoader($this, $parameterBag, $locator);
        }

        $loader = new DelegatingLoader(new LoaderResolver($loaders));

        foreach ($filenames as $path) {
            $loader->load($parameterBag->resolveValue($path));
        }
    }

    private function initializeApps()
    {
        $this->apps = array_reduce($this->registerApps(), function ($apps, ApplicationInterface $app) {
            $apps[$app->getName()] = $app;

            return $apps;
        }, []);

        $this['apps'] = array_map(function (ApplicationInterface $app) {
            return get_class($app);
        }, $this->apps);
    }

    private function initializeProviders()
    {
        $providers = $this->registerProviders();

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }
}
