<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Tests\Unit\Domain\Contract;

use Money\Money;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use OffCut\RestfulApi\Domain\Contract\MoneyInterface;

/**
 * Class MoneyInterfaceTest
 *
 * @package OffCut\RestfulApi\Tests\Domain\Contract
 */
class MoneyInterfaceTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_money_as_value_with_currency()
    {
        /**
         * NOTE (!!): What shadows our MoneyInterface as we believe
         *
         * It prescribes a `getValue` method that encapsulates creation
         * of a Money instance that encapsulates, partially so, Currency
         * implementation based on predefine, and otherwise types.
         */
        $money = $this->getMockBuilder(MoneyInterface::class)
            ->onlyMethods(['getValue'])
            ->getMock();

        /**
         * Method `getVale` is expected to be called twice, at least,
         * based on our test case.
         *
         * NOTE (!!):
         *
         *  The money value is denoted with a `zero` cents under the
         *  South African Rand.
         */
        $money->expects($this->atLeast(2))
            ->method('getValue')
            ->willReturn(new Money('12.0', new Currency('ZAR')));

        /**
         * Have we achieved reusing the resolving of or even lazy loading a
         * money interface so that we do not have to worry about a thing
         * during instantiation?
         */
        self::assertInstanceOf(MoneyInterface::class, $money);

        /**
         * NOTE (!!);
         *
         *  The Money implementation does not account for the trailing zero
         *  on South African rand.
         *
         *   What does this tells us?
         */
        self::assertSame('12', $money->getValue()->getAmount());

        /**
         * WARNING (!):
         *
         *  In design and/or rather encapsulation, this may be a great
         *  deal (for example in DDD).
         *
         *  To ascertain that we are not breaking the Single-Responsibility
         * Principle (SRP), we aught to expose a single maximum traversal
         * mechanism on accessing our methods.
         */
        self::assertSame('ZAR', $money->getValue()->getCurrency()->getCode());
    }
}