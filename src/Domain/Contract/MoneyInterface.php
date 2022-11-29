<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Domain\Contract;

use Money\Money;

/**
 * Interface MoneyInterface
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
interface MoneyInterface
{
    /**
     * @return Money
     */
    public function getValue(): Money;
}