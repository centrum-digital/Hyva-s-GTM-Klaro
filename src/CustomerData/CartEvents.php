<?php

namespace Centrum\GTM\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Session\SessionManagerInterface;
use Centrum\GTM\Model\DataLayer\ContextBuilder;
use Centrum\GTM\Model\DataLayer\Entity\CartBuilder;
use Centrum\GTM\Model\Config;
use Psr\Log\LoggerInterface;

class CartEvents implements SectionSourceInterface
{
    public const SNAPSHOT_KEY = 'centgtm_cart_snapshot';
    private const DIFF_KEY = 'centgtm_cart_diff';

    public function __construct(
        private CheckoutSession $checkoutSession,
        private SessionManagerInterface $session,
        private ContextBuilder $context,
        private CartBuilder $cartBuilder,
        private Config $config,
        private LoggerInterface $logger
    ) {}

    public function getSectionData(): array
    {
        $quote = $this->checkoutSession->getQuote();
        $currMap = $this->mapItems($quote ? $quote->getAllVisibleItems() : []);
        $prevMap = (array)($this->session->getData(self::SNAPSHOT_KEY) ?? []);

        $diff = $this->diff($prevMap, $currMap);

        // zawsze nadpisz snapshot – to jest nowy punkt odniesienia
        $this->session->setData(self::SNAPSHOT_KEY, $currMap);

        // zbuduj eventy z różnic
        $events = [];

        if (!empty($diff['added'])) {
            $items = array_values(array_map(
                fn($d) => $this->toGa4Item($d['item'], $d['qty']),
                $diff['added']
            ));

            $events[] = array_merge(
                $this->context->build('cart'),
                [
                    'event_name' => 'add_to_cart',
                    'currency' => $quote->getQuoteCurrencyCode(),
                    'value' => array_sum(array_map(
                        fn($i) => $i['price'] * $i['quantity'],
                        $items
                    )),
                    'items' => $items,
                    'settings' => [
                        'ga4_measurement_id' => $this->config->getGa4MeasurementId(),
                        'ads_conversion_id' => $this->config->getAdsConversionId(),
                        'ads_conversion_label' => $this->config->getAdsConversionLabel(),
                    ],
                ]
            );
        }

        if (!empty($diff['removed'])) {
            $items = array_values(array_map(
                fn($d) => $this->toGa4Item($d['item'], $d['qty']),
                $diff['removed']
            ));

            $events[] = array_merge(
                $this->context->build('cart'),
                [
                    'event_name' => 'remove_from_cart',
                    'currency' => $quote->getQuoteCurrencyCode(),
                    'value' => array_sum(array_map(
                        fn($i) => $i['price'] * $i['quantity'],
                        $items
                    )),
                    'items' => $items,
                    'settings' => [
                        'ga4_measurement_id' => $this->config->getGa4MeasurementId(),
                        'ads_conversion_id' => $this->config->getAdsConversionId(),
                        'ads_conversion_label' => $this->config->getAdsConversionLabel(),
                    ],
                ]
            );
        }

        // zapisz do sesji na wypadek gdyby front odczytał dopiero przy kolejnym loadzie
        $this->session->setData(self::DIFF_KEY, $events);

        // odczytaj i od razu wyczyść (→ jednorazowe)
        $eventsToSend = (array)$this->session->getData(self::DIFF_KEY) ?: [];
        //$this->session->unsetData(self::DIFF_KEY);

        return [
            'events' => $eventsToSend,
        ];
    }

    private function mapItems(array $items): array
    {
        $out = [];

        foreach ($items as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            $out[(string)$item->getId()] = [
                'qty' => (float)$item->getQty(),
                'item_id' => (int)$item->getId(),
                'product_id' => (int)$item->getProductId(),
                'sku' => (string)$item->getSku(),
                'name' => (string)$item->getName(),
                'price' => (float)$item->getPrice(),
                'row_total' => (float)$item->getRowTotal(),
                'row_total_incl_tax' => (float)$item->getRowTotalInclTax(),
            ];
        }

        return $out;
    }

    private function diff(array $prev, array $next): array
    {
        $added = [];
        $removed = [];

        foreach ($next as $id => $n) {
            $from = isset($prev[$id]) ? (float)$prev[$id]['qty'] : 0.0;
            $to = (float)$n['qty'];

            if ($to > $from) {
                $added[$id] = ['item' => $n, 'qty' => $to - $from];
            } elseif ($to < $from) {
                $removed[$id] = ['item' => $n, 'qty' => $from - $to];
            }
        }

        foreach ($prev as $id => $p) {
            if (!isset($next[$id])) {
                $removed[$id] = ['item' => $p, 'qty' => (float)$p['qty']];
            }
        }

        return ['added' => $added, 'removed' => $removed];
    }

    private function toGa4Item(array $i, float $qty): array
    {
        return [
            'item_id' => (string)($i['sku'] ?? $i['product_id'] ?? $i['item_id']),
            'item_name' => $i['name'] ?? null,
            'price' => (float)($i['price'] ?? $i['row_total_incl_tax'] ?? $i['row_total'] ?? 0),
            'quantity' => $qty,
        ];
    }
}
