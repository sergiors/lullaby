<?php
namespace Sergiors\Lullaby;

use Silex\Application as BaseApplication;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Sergiors\Lullaby\DependencyInjection\Loader\YamlFileLoader;

abstract class Application extends BaseApplication
{
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
     * @param array $values|[]
     */
    public function __construct($environment, $rootDir, array $values = [])
    {
        $this->environment = $environment;
        $this->rootDir = $rootDir;

        parent::__construct($values);
    }

    /**
     * @param LoaderInterface $loader
     */
    abstract public function registerConfiguration(LoaderInterface $loader);

    public function boot()
    {
        $this->registerConfiguration($this->getLoader());
        parent::boot();
    }

    public function getParameters()
    {
        return new ParameterBag([
            'root_dir' => $this->rootDir
        ]);
    }

    protected function getLoader()
    {
        $locator = new FileLocator();
        $resolver = new LoaderResolver([
            new YamlFileLoader($this, $locator)
        ]);

        return new DelegatingLoader($resolver);
    }
}
