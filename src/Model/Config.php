<?php
namespace Centrum\GTM\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const PATH_GENERAL = 'centrum_gtm/general/';
    private const PATH_KLARO   = 'centrum_gtm/klaro_mapping/';

    public function __construct(private ScopeConfigInterface $scope) {}

    private function get(string $path, $default = null)
    {
        $val = $this->scope->getValue($path);
        return $val !== null ? $val : $default;
    }

    private function getGeneral(string $key, $default = null)
    {
        return $this->get(self::PATH_GENERAL . $key, $default);
    }

    private function getKlaro(string $key, $default = null)
    {
        return $this->get(self::PATH_KLARO . $key, $default);
    }

    // === General ===
    public function isEnabled(): bool { return (bool)$this->getGeneral('enabled', 1); }
    public function getQueueTtl(): int { return (int)$this->getGeneral('queue_ttl', 900); }
    public function getQueueMax(): int { return (int)$this->getGeneral('queue_max', 50); }

    public function getGa4MeasurementId(): string { return (string)$this->getGeneral('ga4_measurement_id', ''); }
    public function getAdsConversionId(): string { return (string)$this->getGeneral('ads_conversion_id', ''); }
    public function getAdsConversionLabel(): string { return (string)$this->getGeneral('ads_conversion_label', ''); }

    public function isDebug(): bool { return (bool)$this->getGeneral('debug_mode', 0); }
    public function getSgtmEndpointUrl(): string { return (string)$this->getGeneral('sgtm_endpoint_url', ''); }
    public function getSgtmTimeoutMs(): int { return (int)$this->getGeneral('sgtm_timeout_ms', 3000); }
    public function isSgtmRetry(): bool { return (bool)$this->getGeneral('sgtm_retry', 1); }
    public function getSgtmMaxRetries(): int { return (int)$this->getGeneral('sgtm_max_retries', 2); }
    public function getSessionTimeoutMin(): int { return (int)$this->getGeneral('session_timeout_min', 30); }

    // === Klaro mapping ===
    public function getKlaroMapping(): array
    {
        return [
            'ad_storage'        => (string)$this->getKlaro('ad_storage', ''),
            'analytics_storage' => (string)$this->getKlaro('analytics_storage', ''),
            'ad_user_data'      => (string)$this->getKlaro('ad_user_data', ''),
            'ad_personalization'=> (string)$this->getKlaro('ad_personalization', ''),
        ];
    }

    public function getKlaroServiceFor(string $signal): ?string
    {
        $map = $this->getKlaroMapping();
        return $map[$signal] ?? null;
    }
}
