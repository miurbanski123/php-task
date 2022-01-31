<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    /**
     * @var int
     */
    private $quantity;

    /**
     * @var Product
     */
    private $product;

    /**
     * Item constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        if ($quantity < $product->getMinimumQuantity()) {
            throw new \InvalidArgumentException();
        }
        $this->quantity = $quantity;
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }

    /**
     * @param int $quantity
     * @return Item
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): Item
    {
        if ($quantity < $this->quantity) {
            throw new QuantityTooLowException();
        }
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Return total gross price
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $totalPrice = $this->getTotalPrice();
        $taxTotalCost = ($this->getProduct()->getTax() / 100.00) * $totalPrice;

        return (int) round($taxTotalCost + $totalPrice, 0, PHP_ROUND_HALF_UP);
    }
}
