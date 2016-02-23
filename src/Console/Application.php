<?php

namespace Sergiors\Lullary\Console;

use Sergiors\Lullaby\ApplicationInterface;
use Symfony\Component\Console\Application as ApplicationBase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class Application extends ApplicationBase
{
    private $container;

    public function __construct(ApplicationInterface $app)
    {
        $this->container = $app->getContainer();

        parent::__construct('Lullaby', \Sergiors\Lullaby\Application::LULLABY_VERSION);
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
