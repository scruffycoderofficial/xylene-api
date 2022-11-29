<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Console;

use Symfony\Component\Console\Application;

/**
 * Class App.
 *
 * @package OffCut\RestfulApi\Console
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class App extends Application
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

        /*
         * Override the name of this Application and give it a version
         */
        parent::__construct('OffCut Solutions Restful Api Console', \OffCut\RestfulApi\Core\App::VERSION);
    }
}