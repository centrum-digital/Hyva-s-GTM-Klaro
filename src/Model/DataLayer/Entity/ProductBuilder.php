<?php
namespace Centrum\GTM\Model\DataLayer\Entity;

use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\Registry;
use Magento\Quote\Model\Quote\Item as QuoteItem;

class ProductBuilder
{
    public function __construct(
        private Registry $registry,
        private CatalogHelper $catalogHelper
    ) {}

    public function build(): array
    {
        $product = $this->registry->registry('current_product');
        if (!$product) {
            return [
                'currency' => null,
                'value'    => 0,
                'items'    => []
            ];
        }

        $currency = $product->getStore()->getCurrentCurrencyCode();
        $price    = (float)$product->getFinalPrice();

        return [
            'currency' => $currency,
            'value'    => $price,
            'items'    => [[
                'item_id'    => $product->getSku(),
                'item_name'  => (string)$product->getName(),
                'price'      => $price,
                'item_brand' => (string)$product->getAttributeText('manufacturer') ?: null,
                'quantity'   => 1
            ]]
        ];
    }

    public function buildFromQuoteItem(QuoteItem $item, array $overrides = []): array
    {
        $product  = $item->getProduct();
        $quantity = isset($overrides['quantity'])
            ? (int)$overrides['quantity']
            : (int)($item->getQty() ?? 1);

        $data = [
            'item_id'   => (string)$product->getSku(),
            'item_name' => (string)$product->getName(),
            'price'     => (float)$item->getCalculationPrice(),
            'quantity'  => $quantity,
        ];

        return $overrides + $data;
    }
}
