<?php

declare(strict_types=1);

namespace Xylene\Console;

use Symfony\Component\Console\Application as ParentApplication;

/**
 * Class Application.
 *
 * @package Xylen\Console
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class Application extends ParentApplication
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
        parent::__construct('Xylene Console', \OffCut\RestfulApi\Core\AppKernel::VERSION);
    }
}