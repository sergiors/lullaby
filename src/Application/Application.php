<?php

namespace Sergiors\Lullaby\Application;

use Pimple\Container;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
abstract class Application implements ApplicationInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app)
    {
    }

    /**
     * {@inheritdoc}
     */
    final public function getNamespace()
    {
        $class = get_class($this);
        return substr($class, 0, strrpos($class, '\\'));
    }

    /**
     * {@inheritdoc}
     */
    final public function getPath()
    {
        if (null === $this->path) {
            $reflObject = new \ReflectionObject($this);
            $this->path = dirname($reflObject->getFileName());
        }

        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    final public function getName()
    {
        if (null === $this->name) {
            $name = get_class($this);
            $pos = strrpos($name, '\\') + 1;
            $this->name = substr($name, $pos);
        }

        return $this->name;
    }
}
