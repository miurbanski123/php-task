<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    const ALLOWED_TAX_THRESHOLDS = [0, 5, 8, 23];

    /**
     * @var \Recruitment\Tests\Cart\int
     */
    private $id;

    /**
     * @var int
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $minimumQuantity;

    /**
     * Tax percent value
     * @var int
     */
    private $tax;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->setMinimumQuantity(1);
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $price
     * @return Product
     */
    public function setUnitPrice(int $price): Product
    {
        if ($price === 0) {
            throw new InvalidUnitPriceException();
        }
        $this->unitPrice = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): Product
    {
        if ($minimumQuantity === 0) {
            throw new \InvalidArgumentException();
        }
        $this->minimumQuantity = $minimumQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $tax
     * @return Product
     */
    public function setTax(int $tax): Product
    {
        if (!in_array($tax, self::ALLOWED_TAX_THRESHOLDS)) {
            throw new \InvalidArgumentException();
        }
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }
}
