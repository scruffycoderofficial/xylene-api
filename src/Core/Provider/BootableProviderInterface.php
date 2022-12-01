<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core\Provider;

use OffCut\RestfulApi\Core\AppKernel as Application;

/**
 * Interface BootableProviderInterface
 *
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
