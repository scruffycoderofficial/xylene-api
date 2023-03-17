<?php

namespace Xylene\Console;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * Class Application.
 *
 * @package Xylene\Console
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class Application extends BaseApplication
{
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

        parent::__construct('Xylene Framework Console', '0.0.1');
    }
}
