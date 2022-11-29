<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Domain\Contract;

use Money\Money;

/**
 * Interface MoneyInterface
 *
 * An interface that represents a Money Value Object.
 *
 * @package OffCut\RestfulApi\Domain\Contract
 */
interface MoneyInterface
{
    /**
     * @return Money
     */
    public function getValue(): Money;
}