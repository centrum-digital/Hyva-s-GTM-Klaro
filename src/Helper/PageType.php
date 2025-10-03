<?php
namespace Centrum\GTM\Helper;

use Magento\Framework\App\RequestInterface;

class PageType
{
    public function __construct(private RequestInterface $request) {}

    public function get(): string
    {
        $handle = $this->request->getFullActionName();
            return match ($handle) {
                'catalog_category_view'       => 'plp',
                'catalog_product_view'        => 'pdp',
                'checkout_cart_index'         => 'cart',
                'hyva_checkout_index_index'   => 'checkout',
                'checkout_onepage_success'    => 'checkout_success',
                'catalogsearch_result_index'  => 'search',
                default                       => 'other',
            };
    }
}
