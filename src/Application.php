<?php
namespace Sergiors\Lullaby;

use Silex\Application as BaseApplication;
use Symfony\Component\Config\Loader\LoaderInterface;
use Sergiors\Silex\Provider\ConfigServiceProvider;

/**
 * @author Sérgio Rafael Siquira <sergio@inbep.com.br>
 */
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
        parent::__construct($values);

        $this->environment = $environment;
        $this->rootDir = $rootDir;

        $this->register(new ConfigServiceProvider(), [
            'config.replacements' => [
                'root_dir' => $this->rootDir
            ]
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
        parent::boot();
    }

    /**
     * @param LoaderInterface $loader
     */
    abstract protected function registerConfiguration(LoaderInterface $loader);
}
