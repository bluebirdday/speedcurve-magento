<?php

declare(strict_types=1);

namespace Bluebirdday\SpeedcurveMagento\Helper;

use Bluebirdday\SpeedcurveMagento\Model\Config\Source\ConsentLogic;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data.
 */
class Data extends AbstractHelper
{
    private const XML_PATH_SPEEDCURVE_ENABLED = 'speedcurve/general/enabled';
    private const XML_PATH_SPEEDCURVE_LUX_ID = 'speedcurve/general/lux_id';
    private const XML_PATH_SPEEDCURVE_CATEGORY_PAGE_LABEL = 'speedcurve/page_labels/category_page';
    private const XML_PATH_SPEEDCURVE_PRODUCT_PAGE_LABEL = 'speedcurve/page_labels/product_page';
    private const XML_PATH_SPEEDCURVE_COOKIE_CONSENT_ENABLED = 'speedcurve/general/enable_cookie_consent';
    private const XML_PATH_SPEEDCURVE_COOKIE_NAME = 'speedcurve/general/cookie_name';
    private const XML_PATH_SPEEDCURVE_COOKIE_VALUE = 'speedcurve/general/cookie_value';
    private const XML_PATH_SPEEDCURVE_CONSENT_LOGIC = 'speedcurve/general/consent_logic';

    /**
     * Check if Speedcurve RUM is enabled.
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isEnabled(int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SPEEDCURVE_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get Speedcurve LUX ID.
     *
     * @param int|null $storeId
     *
     * @return string|null
     */
    public function getLuxId(int $storeId = null): ?string
    {
        return $this->getTextConfigValue(self::XML_PATH_SPEEDCURVE_LUX_ID, $storeId);
    }

    /**
     * Get category page label.
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getCategoryPageLabel(int $storeId = null): string
    {
        return $this->getTextConfigValue(
            self::XML_PATH_SPEEDCURVE_CATEGORY_PAGE_LABEL,
            $storeId
        ) ?? 'category-page';
    }

    /**
     * Get product page label.
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getProductPageLabel(int $storeId = null): string
    {
        return $this->getTextConfigValue(
            self::XML_PATH_SPEEDCURVE_PRODUCT_PAGE_LABEL,
            $storeId
        ) ?? 'product-page';
    }

    /**
     * Check if cookie consent check is enabled.
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isCookieConsentEnabled(int $storeId = null): bool
    {
        return $this->isEnabled($storeId)
            && $this->scopeConfig->isSetFlag(
                self::XML_PATH_SPEEDCURVE_COOKIE_CONSENT_ENABLED,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
    }

    /**
     * Get consent cookie name.
     *
     * @param int|null $storeId
     *
     * @return string|null
     */
    public function getCookieName(int $storeId = null): ?string
    {
        return $this->getTextConfigValue(self::XML_PATH_SPEEDCURVE_COOKIE_NAME, $storeId);
    }

    /**
     * Get consent cookie value.
     *
     * @param int|null $storeId
     *
     * @return string|null
     */
    public function getCookieValue(int $storeId = null): ?string
    {
        return $this->getTextConfigValue(self::XML_PATH_SPEEDCURVE_COOKIE_VALUE, $storeId);
    }

    /**
     * Get consent check logic.
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getConsentLogic(int $storeId = null): string
    {
        return $this->getTextConfigValue(
            self::XML_PATH_SPEEDCURVE_CONSENT_LOGIC,
            $storeId
        ) ?? ConsentLogic::LOGIC_CONTAINS;
    }

    /**
     * Get text config value.
     *
     * @param string $path
     * @param int|null $storeId
     *
     * @return string|null
     */
    private function getTextConfigValue(string $path, ?int $storeId = null): ?string
    {
        $value = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
        $value = is_string($value) ? trim($value) : null;

        return $value !== '' ? $value : null;
    }
}
