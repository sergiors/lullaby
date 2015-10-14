<?php
namespace Sergiors\Lullaby\DependencyInjection\Loader;

use Symfony\Component\Config\Loader\FileLoader as BaseFileLoader;
use Symfony\Component\Config\FileLocatorInterface;

abstract class FileLoader extends BaseFileLoader
{
    /**
     * @var \Pimple
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param \Pimple $container A Pimple instance
     * @param FileLocatorInterface $locator A FileLocator instance
     */
    public function __construct(\Pimple $container, FileLocatorInterface $locator)
    {
        $this->container = $container;

        parent::__construct($locator);
    }
}
