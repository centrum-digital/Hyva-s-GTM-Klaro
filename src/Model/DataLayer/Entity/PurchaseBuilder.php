<?php
namespace Centrum\GTM\Model\DataLayer\Entity;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Centrum\GTM\Model\DataLayer\Entity\OrderItemsBuilder;
use Centrum\GTM\CustomerData\CartEvents;

class PurchaseBuilder
{
    public function __construct(
        private CheckoutSession $checkoutSession,
        private SessionManagerInterface $session,
        private OrderItemsBuilder $orderItemsBuilder
    ) {}

    public function build(): array
    {
        try {
            /** @var OrderInterface $order */
            $order = $this->checkoutSession->getLastRealOrder();
            if (!$order || !$order->getId()) {
                return [
                    'transaction_id' => null,
                    'affiliation'    => null,
                    'currency'       => null,
                    'value'          => 0,
                    'items'          => []
                ];
            }

            $this->session->setData(CartEvents::SNAPSHOT_KEY, []);

            return [
                'transaction_id' => $order->getIncrementId(),
                'affiliation'    => $order->getStoreName(),
                'currency'       => $order->getOrderCurrencyCode(),
                'value'          => (float) $order->getGrandTotal(),
                'coupon'         => $order->getCouponCode() ?: null,
                'items'          => $this->orderItemsBuilder->build($order),
            ];
        } catch (\Exception $e) {
            return [
                'transaction_id' => null,
                'affiliation'    => null,
                'currency'       => null,
                'value'          => 0,
                'items'          => []
            ];
        }
    }
}
