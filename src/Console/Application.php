<?php

namespace Sergiors\Lullaby\Console;

use Sergiors\Lullaby\Kernel;
use Sergiors\Lullaby\ContainerAwareInterface;
use Pimple\Container;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class Application extends BaseApplication
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        parent::__construct('Lullaby', Kernel::LULLABY_VERSION);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->all() as $command) {
            if ($command instanceof ContainerAwareInterface) {
                $command->setContainer($this->container);
            }
        }

        return parent::doRun($input, $output);
    }
}
