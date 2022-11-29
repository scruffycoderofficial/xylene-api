<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Domain\Util;

use Money\Currency;
use Money\Money as BaseMoney;
use InvalidArgumentException;
use OffCut\RestfulApi\Domain\Contract\MoneyInterface;

final class Money implements MoneyInterface
{
    /**
     * @var $value
     */
    protected $value;

    /**
     * @var $currency
     */
    protected $currency;

    /**
     * Money constructor.
     * @param $value
     * @param $currency
     */
    public function __construct($value, $currency)
    {
        $this->value = $value;

        if(!$currency instanceof Currency){
            throw new InvalidArgumentException("The currency value should be a known object.");
        }

        $this->currency = $currency;
    }

    /**
     * @return BaseMoney
     */
    public function getValue(): BaseMoney
    {
        return new BaseMoney($this->value, $this->currency);
    }
}