<?php
namespace Centrum\GTM\Model\DataLayer\Entity;

use Magento\Checkout\Model\Session as CheckoutSession;

class CartBuilder
{
    public function __construct(private CheckoutSession $session) {}

    public function build(): array
    {
        $quote = $this->session->getQuote();
        $items = [];

        foreach ($quote->getAllVisibleItems() as $i) {
            $items[] = [
                'item_id'   => $i->getSku(),
                'item_name' => $i->getName(),
                'price'     => (float)$i->getPriceInclTax(),
                'quantity'  => (int)$i->getQty()
            ];
        }

        return [
            'currency' => $quote->getQuoteCurrencyCode(),
            'value'    => (float)$quote->getGrandTotal(),
            'items'    => $items
        ];
    }
}
