<?php

declare(strict_types=1);

namespace Xylene\Contract;

/**
 * Interface UseCaseInterface.
 */
interface UseCaseInterface
{
    /**
     * Executes the business logic of your application's use case.
     *
     * @param object $request an object containing request data in public fields
     *
     * @return object an object containing response data in public fields
     */
    public function execute($request);
}
