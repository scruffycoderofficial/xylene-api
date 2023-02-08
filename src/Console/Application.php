<?php

declare(strict_types=1);

namespace Xylene\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Application as ParentApplication;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class Application.
 *
 * @package Xylen\Console
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class Application extends ParentApplication
{
    private $kernel;
    private $commandsRegistered = false;
    private $registrationErrors = [];

    public const VERSION = '0.0.1';

    /**
     * Application constructor.
     *
     * @param iterable $commands
     */
    public function __construct(iterable $commands)
    {

        $commands = $commands instanceof \Traversable ? \iterator_to_array($commands) : $commands;

        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct('Xylene Console', self::VERSION);

        $inputDefinition = $this->getDefinition();

        $inputDefinition->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', $kernel->getEnvironment()));
        $inputDefinition->addOption(new InputOption('--no-debug', null, InputOption::VALUE_NONE, 'Switch off debug mode.'));
    }

    /**
     * Gets the Kernel associated with this Console.
     *
     * @return HttpKernelInterface
     */
    public function getKernel(): HttpKernelInterface
    {
        return $this->kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function reset():  void
    {
        if ($this->kernel instanceof \Xylene\Foundation\Application && $this->kernel->getContainer()->has('services_resetter')) {

            try {

                $this->kernel->getContainer()->get('services_resetter')->reset();

            } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
            }
        }
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        $this->registerCommands();

        if ($this->registrationErrors) {
            $this->renderRegistrationErrors($input, $output);
        }

        if (method_exists($this, 'setDispatcher') && $this->kernel instanceof \Xylene\Foundation\Application) {
            try {

                $this->setDispatcher($this->kernel->getContainer()->get(EventDispatcherInterface::class));

            } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
            }
        }

        return parent::doRun($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $name): Command
    {
        $this->registerCommands();

        return parent::find($name);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): mixed
    {
        $this->registerCommands();

        $command = parent::get($name);

        if ($command instanceof ContainerAwareInterface && $this->kernel instanceof \Xylene\Foundation\Application) {
            $command->setContainer($this->kernel->getContainer());
        }

        return $command;
    }

    /**
     * {@inheritdoc}
     */
    public function all(string $namespace = null): array
    {
        $this->registerCommands();

        return parent::all($namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function getLongVersion(): string
    {
        return parent::getLongVersion().sprintf(' (env: <comment>%s</>, debug: <comment>%s</>) <bg=#0057B7;fg=#FFDD00>#StandWith</><bg=#FFDD00;fg=#0057B7>Ukraine</> <href=https://sf.to/ukraine>https://sf.to/ukraine</>', $this->kernel->getEnvironment(), $this->kernel->isDebug() ? 'true' : 'false');
    }

    /**
     * {@inheritdoc}
     */
    public function add(Command $command): ?Command
    {
        $this->registerCommands();

        return parent::add($command);
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output): int
    {
        if (!$command instanceof ListCommand) {
            if ($this->registrationErrors) {
                $this->renderRegistrationErrors($input, $output);
                $this->registrationErrors = [];
            }

            return parent::doRunCommand($command, $input, $output);
        }

        $returnCode = parent::doRunCommand($command, $input, $output);

        if ($this->registrationErrors) {
            $this->renderRegistrationErrors($input, $output);
            $this->registrationErrors = [];
        }

        return $returnCode;
    }

    protected function registerCommands(): void
    {
        if ($this->commandsRegistered) {
            return;
        }

        $this->commandsRegistered = true;

        if ($this->kernel instanceof \Xylene\Foundation\Application) {
            $this->kernel->boot();

            $container = $this->kernel->getContainer();
        }

        if ($container->has('console.command_loader')) {
            $this->setCommandLoader($container->get('console.command_loader'));
        }

        if ($container->hasParameter('console.command.ids')) {
            $lazyCommandIds = $container->hasParameter('console.lazy_command.ids') ? $container->getParameter('console.lazy_command.ids') : [];
            foreach ($container->getParameter('console.command.ids') as $id) {
                if (!isset($lazyCommandIds[$id])) {
                    try {
                        $this->add($container->get($id));
                    } catch (Throwable $e) {
                        $this->registrationErrors[] = $e;
                    }
                }
            }
        }
    }

    private function renderRegistrationErrors(InputInterface $input, OutputInterface $output)
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        (new SymfonyStyle($input, $output))->warning('Some commands could not be registered:');

        foreach ($this->registrationErrors as $error) {
            $this->doRenderThrowable($error, $output);
        }
    }
}