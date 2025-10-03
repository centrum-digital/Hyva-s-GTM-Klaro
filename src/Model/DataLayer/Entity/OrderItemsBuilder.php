<?php
namespace Centrum\GTM\Model\DataLayer\Entity;

use Magento\Sales\Api\Data\OrderInterface;

class OrderItemsBuilder
{
    public function build(OrderInterface $order): array
    {
        $items = [];
        foreach ($order->getAllVisibleItems() as $i) {
            $items[] = [
                'item_id'   => $i->getSku(),
                'item_name' => $i->getName(),
                'price'     => (float)$i->getPriceInclTax(),
                'quantity'  => (int)$i->getQtyOrdered(),
            ];
        }

        return [
            'currency' => $order->getOrderCurrencyCode(),
            'value'    => (float)$order->getGrandTotal(),
            'coupon'   => $order->getCouponCode(),
            'items'    => $items,
        ];
    }
}
