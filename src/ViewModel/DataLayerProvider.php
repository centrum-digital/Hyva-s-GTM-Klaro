<?php
namespace Centrum\GTM\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Centrum\GTM\Model\Config;
use Centrum\GTM\Helper\PageType;
use Centrum\GTM\Model\DataLayer\ContextBuilder;
use Centrum\GTM\Model\DataLayer\Entity\ProductBuilder;
use Centrum\GTM\Model\DataLayer\Entity\ListBuilder;
use Centrum\GTM\Model\DataLayer\Entity\SearchBuilder;
use Centrum\GTM\Model\DataLayer\Entity\CartBuilder;
use Centrum\GTM\Model\DataLayer\Entity\PurchaseBuilder;

class DataLayerProvider implements ArgumentInterface
{
    public function __construct(
        private Config $config,
        private PageType $pageType,
        private ContextBuilder $context,
        private ProductBuilder $product,
        private SearchBuilder $search,
        private ListBuilder $list,
        private CartBuilder $cart,
        private PurchaseBuilder $purchase,

    ) {}

    public function getJsConfig(): array
    {
        return [
            'enabled' => $this->config->isEnabled(),
            'queue' => [
                'ttl' => $this->config->getQueueTtl(),
                'max' => $this->config->getQueueMax()
            ],
            'ids' => [
                'ga4_measurement_id' => $this->config->getGa4MeasurementId(),
                'ads_conversion_id'  => $this->config->getAdsConversionId(),
                'ads_conversion_label' => $this->config->getAdsConversionLabel()
            ],
            'endpoint' => [
                'url' => $this->config->getSgtmEndpointUrl(),
                'timeout' => $this->config->getSgtmTimeoutMs(),
                'retry' => $this->config->isSgtmRetry(),
                'max_retries' => $this->config->getSgtmMaxRetries()
            ],
            'debug_mode' => $this->config->isDebug(),
            'session_timeout_min' => $this->config->getSessionTimeoutMin(),
            'klaro_mapping' => $this->config->getKlaroMapping(),
        ];
    }

    public function getPayload(?Collection $plpCollection = null): array
    {
        $type = $this->pageType->get();
        $context = $this->context->build($type);


        $payload = [
            'settings' => [
                'ga4_measurement_id'   => $this->config->getGa4MeasurementId(),
                'ads_conversion_id'    => $this->config->getAdsConversionId(),
                'ads_conversion_label' => $this->config->getAdsConversionLabel(),
            ],
            'events' => []
        ];


        switch ($type) {
            case 'pdp':
                $productData = $this->product->build();

            $payload['events'][] = [
                'name'   => 'view_item',
                'params' => array_merge($context, [
                    'currency' => $productData['currency'],
                    'value'    => $productData['value'],
                    'items'    => $productData['items'],
                    'settings_ga4id' => $payload['settings']['ga4_measurement_id'],
                    'settings_awid'  => $payload['settings']['ads_conversion_id'],
                    'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                ]),
            ];
                break;

            case 'plp':
                if ($plpCollection) {
                    $listData = $this->list->build($plpCollection);

                    $payload['events'][] = [
                        'name'   => 'view_item_list',
                        'params' => array_merge($context, [
                            'item_list_id'   => $listData['item_list_id'],
                            'item_list_name' => $listData['item_list_name'],
                            'items'          => $listData['items'],
                            'settings_ga4id' => $payload['settings']['ga4_measurement_id'],
                            'settings_awid'  => $payload['settings']['ads_conversion_id'],
                            'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                        ]),
                    ];
                } else {
                    $payload['events'][] = [
                        'name'   => 'view_item_list',
                        'params' => array_merge($context, [
                            'item_list_id'   => null,
                            'item_list_name' => null,
                            'items'          => [],
                            'settings_ga4id' => $payload['settings']['ga4_measurement_id'],
                            'settings_awid'  => $payload['settings']['ads_conversion_id'],
                            'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                        ]),
                    ];
                }
                break;

            
            case 'search':
                if ($plpCollection) {
                    $searchData = $this->search->build($plpCollection);

                    $payload['events'][] = [
                        'name'   => 'search',
                        'params' => array_merge($context, [
                            'search_term'      => $searchData['search_term'],
                            'item_list_id'     => $searchData['item_list_id'],
                            'item_list_name'   => $searchData['item_list_name'],
                            'items'            => $searchData['items'],
                            'settings_ga4id'   => $payload['settings']['ga4_measurement_id'],
                            'settings_awid'    => $payload['settings']['ads_conversion_id'],
                            'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                        ])
                    ];
                } else {
                    $payload['events'][] = [
                        'name'   => 'search',
                        'params' => array_merge($context, [
                            'search_term'      => null,
                            'items'            => [],
                            'settings_ga4id'   => $payload['settings']['ga4_measurement_id'],
                            'settings_awid'    => $payload['settings']['ads_conversion_id'],
                            'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                        ])
                    ];
                }
                break;


            case 'cart':
                $cartData = $this->cart->build();

                $payload['events'][] = [
                    'name'   => 'view_cart',
                    'params' => array_merge($context, [
                        'currency'        => $cartData['currency'],
                        'value'           => $cartData['value'],
                        'items'           => $cartData['items'],
                        'settings_ga4id'   => $payload['settings']['ga4_measurement_id'],
                        'settings_awid'    => $payload['settings']['ads_conversion_id'],
                        'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                    ])
                ];
                break;

            

            case 'checkout':
                $cartData = $this->cart->build();

                $payload['events'][] = [
                    'name'   => 'begin_checkout',
                    'params' => array_merge($context, [
                        'currency'         => $cartData['currency'],
                        'value'            => $cartData['value'],
                        'items'            => $cartData['items'],
                        'settings_ga4id'   => $payload['settings']['ga4_measurement_id'],
                        'settings_awid'    => $payload['settings']['ads_conversion_id'],
                        'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                    ])
                ];
                break;


            case 'checkout_success':
                $purchaseData = $this->purchase->build();

                $payload['events'][] = [
                    'name'   => 'purchase',
                    'params' => array_merge($context, [
                        'transaction_id'  => $purchaseData['transaction_id'],
                        'affiliation'     => $purchaseData['affiliation'],
                        'currency'        => $purchaseData['currency'],
                        'value'           => $purchaseData['value'],
                        'coupon'          => $purchaseData['coupon'],
                        'items'           => $purchaseData['items'],
                        'settings_ga4id'   => $payload['settings']['ga4_measurement_id'],
                        'settings_awid'    => $payload['settings']['ads_conversion_id'],
                        'settings_awlabel' => $payload['settings']['ads_conversion_label'],
                    ])
                ];
                break;


            default:
                break;
        }


        return $payload;
    }
}
