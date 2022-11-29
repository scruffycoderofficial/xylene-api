<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Domain\Entity;

use OffCut\RestfulApi\Domain\Contract\MoneyInterface;

/**
 * Class Product
 *
 * @package OffCut\RestfulApi\Domain\Entity
 */
final class Product
{
    /**
     * The name of the product
     *
     * @var $name
     */
    private $name;

    /**
     * The total number of units in a single Product
     *
     * @var $unitPerItem
     */
    private $unitPerItem;

    /**
     * The price of a single unit in a Product
     *
     * @var $pricePerUnit
     */
    private $pricePerUnit;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnitPerItem(): int
    {
        return $this->unitPerItem;
    }

    /**
     * @param int $unitPerItem
     */
    public function setUnitPerItem(int $unitPerItem): self
    {
        $this->unitPerItem = $unitPerItem;

        return $this;
    }

    /**
     * @return MoneyInterface
     */
    public function getPricePerUnit(): MoneyInterface
    {
        return $this->pricePerUnit;
    }

    /**
     * @param MoneyInterface $pricePerUnit
     */
    public function setPricePerUnit(MoneyInterface $pricePerUnit): self
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }
}