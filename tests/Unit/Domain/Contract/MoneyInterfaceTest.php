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
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class MoneyInterfaceTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_money_as_value_with_currency()
    {
        $money = $this->getMockBuilder(MoneyInterface::class)
            ->onlyMethods(['getValue'])
            ->getMock();

        $money->expects($this->atLeast(2))
            ->method('getValue')
            ->willReturn(new Money('12.0', new Currency('ZAR')));

        self::assertInstanceOf(MoneyInterface::class, $money);

        /** @TODO
         * - Look into the issue of Decimals and so forth
         * - Also look at using a a Factory Design Pattern to hide
         *   the complexity of dealing with Money (Amount and Currency).
         */
        self::assertSame('12', $money->getValue()->getAmount());
        self::assertSame('ZAR', $money->getValue()->getCurrency()->getCode());
    }
}