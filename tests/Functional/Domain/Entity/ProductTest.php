<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Tests\Functional\Domain\Entity;

use Money\Currency;
use OffCut\RestfulApi\Domain\Entity\Product;
use OffCut\RestfulApi\Domain\Util\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductTest
 *
 * @package OffCut\RestfulApi\Tests\Functional\Domain\Entity
 */
class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_a_product()
    {
        $product = (new Product())
            ->setName('Castle Black')
            ->setUnitPerItem(12)
            ->setPricePerUnit(
                new Money('20.00', new Currency('ZAR'))
            );

        self::assertSame('20', $product->getPricePerUnit()->getValue()->getAmount());
    }
}

