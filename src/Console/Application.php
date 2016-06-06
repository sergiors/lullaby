<?php

namespace Sergiors\Lullaby\Console;

use Sergiors\Lullaby\KernelInterface;
use Sergiors\Lullaby\Kernel;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class Application extends BaseApplication
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
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
            if (isset($this->kernel['di.container'])
                && $command instanceof ContainerAwareInterface
            ) {
                $command->setContainer($this->kernel['di.container']);
            }
        }

        return parent::doRun($input, $output);
    }
}
