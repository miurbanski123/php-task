<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

class Order
{
    /**
     * @var
     */
    private $orderId;

    /**
     * @var array
     */
    private $items;

    /**
     * @param int $tax
     * @return string
     */
    private function formatTaxThreshold(int $tax): string
    {
        return $tax . '%';
    }

    /**
     * Order constructor.
     * @param int $orderId
     * @param array $items
     */
    public function __construct(int $orderId, array $items)
    {
        $this->orderId = $orderId;
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        $items = [];
        $i = 0;
        $totalPrice = 0;
        $totalGrossPrice = 0;

        /**
         * @var $item Item
         */
        foreach ($this->items as $item) {
            $items[] = [
                'id' => ++$i,
                'quantity' => $item->getQuantity(),
                'tax' => $this->formatTaxThreshold($item->getProduct()->getTax()),
                'total_price' => $item->getTotalPrice(),
                'total_gross_price' => $item->getTotalPriceGross(),
            ];
            $totalPrice += $item->getTotalPrice();
            $totalGrossPrice += $item->getTotalPriceGross();
        }
        return [
            'id' => $this->orderId,
            'items' => $items,
            'total_price' => $totalPrice,
            'total_gross_price' => $totalGrossPrice,
        ];
    }
}
