<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

class Cart
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Return index of array, if product exists; otherwise return -1
     * @param Product $product
     * @return int
     */
    private function findProduct(Product $product): int
    {
        $index = current(
            array_keys(
                array_filter($this->items, function ($item) use ($product) {
                    /**
                     * @var $item Item
                     */
                    return $item->getProduct() === $product;
                })
            )
        );
        return $index !== false ? $index : -1;
    }

    /**
     * Remove all items from Cart
     */
    private function removeItems(): void
    {
        $this->items = [];
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        $index = $this->findProduct($product);
        if ($index !== -1) {
            $item = $this->items[$index];
            /**
             * @var $item Item
             */
            $item->setQuantity(
                $item->getQuantity() + $quantity
            );
        } else {
            $item = new Item($product, $quantity);
            $this->items[] = $item;
        }
        return $this;
    }

    /**
     * @param int $index
     * @return Item
     */
    public function getItem(int $index): Item
    {
        if (!isset($this->items[$index])) {
            throw new OutOfBoundsException();
        }
        return $this->items[$index];
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return is_array($this->items) ? $this->items : [];
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;
        /**
         * @var $item Item
         */
        foreach ($this->getItems() as $item) {
            $totalPrice += ($item->getProduct()->getUnitPrice() * $item->getQuantity());
        }
        return $totalPrice;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        $this->items = array_values(
            array_filter($this->items, function ($item) use ($product) {
                /**
                 * @var $item Item
                 */
                return $item->getProduct() !== $product;
            })
        );
    }

    /**
     * @param Product $product
     * @param int $int
     * @return Cart
     */
    public function setQuantity(Product $product, int $int): Cart
    {
        $index = $this->findProduct($product);
        if ($index !== -1) {
            $this->items[$index]->setQuantity($int);
        } else {
            $this->addProduct($product, $int);
        }
        return $this;
    }

    /**
     * @param int $int
     * @return Order
     */
    public function checkout(int $int): Order
    {
        $order = new Order($int, $this->items);
        $this->removeItems();
        return $order;
    }
}
