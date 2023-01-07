<?php

declare(strict_types=1);

namespace Xylene\Provider\Contract;

use Xylene\Foundation\Application as Application;

/**
 * Interface BootableProviderInterface
 *
 * @package Xylene\Provider\Contract
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
interface BootableProviderInterface
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function boot(Application $app): void;
}
