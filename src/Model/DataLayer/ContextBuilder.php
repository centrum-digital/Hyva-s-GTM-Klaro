<?php
namespace Centrum\GTM\Model\DataLayer;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use Centrum\GTM\Model\Config;

class ContextBuilder
{
    public function __construct(
        private StoreManagerInterface $storeManager,
        private ResolverInterface $locale,
        private PageConfig $pageConfig,
        private Config $config
    ) {}

    public function build(string $pageType): array
    {
        $store = $this->storeManager->getStore();

        return [
            'currency'           => $store->getCurrentCurrencyCode(),
            'language'           => $this->locale->getLocale(),
            'debug_mode'         => $this->config->isDebug(),
            'page_location'      => $this->sanitizeUrl($store->getCurrentUrl(false)),
            'page_referrer'      => $_SERVER['HTTP_REFERER'] ?? '',
            'page_title'         => $this->pageConfig->getTitle()->get(),
        ];
    }

    private function sanitizeUrl(string $url): string
    {
        $parsed = parse_url($url);

        $query = '';
        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $params);
            unset($params['___store']);
            $query = http_build_query($params);
        }

        return ($parsed['scheme'] ?? 'https') . '://' . ($parsed['host'] ?? '')
            . ($parsed['path'] ?? '')
            . ($query ? '?' . $query : '');
    }
}
