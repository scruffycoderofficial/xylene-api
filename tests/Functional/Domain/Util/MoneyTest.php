<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Tests\Functional\Domain\Util;

use Money\Currency;
use OffCut\RestfulApi\Domain\Util\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class MoneyTest
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class MoneyTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_money()
    {
        $money = new Money('12.0', new Currency('ZAR'));

        self::assertSame('12', $money->getValue()->getAmount());
    }
}