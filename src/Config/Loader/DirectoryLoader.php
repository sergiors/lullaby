<?php

namespace Sergiors\Lullaby\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class DirectoryLoader extends FileLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($file, $type = null)
    {
        $file = rtrim($file, '/');
        $path = $this->locator->locate($file);

        foreach (scandir($path) as $dir) {
            if ('.' !== $dir[0]) {
                if (is_dir($path.'/'.$dir)) {
                    $dir .= '/'; // append / to allow recursion
                }

                $this->setCurrentDir($path);
                $this->import($dir, null, false, $path);
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        if ('directory' === $type) {
            return true;
        }

        return null === $type && is_string($resource) && '/' === substr($resource, -1);
    }
}
