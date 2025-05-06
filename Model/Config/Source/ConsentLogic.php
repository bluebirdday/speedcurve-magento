<?php

declare(strict_types=1);

namespace Bluebirdday\SpeedcurveMagento\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class ConsentLogic.
 */
class ConsentLogic implements OptionSourceInterface
{
    public const LOGIC_EXISTS = 'exists';
    public const LOGIC_CONTAINS = 'contains';
    public const LOGIC_NOT_CONTAINS = 'not_contains';

    /**
     * Convert options to array.
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::LOGIC_EXISTS,
                'label' => __('Cookie Exists')
            ],
            [
                'value' => self::LOGIC_CONTAINS,
                'label' => __('Value Contains')
            ],
            [
                'value' => self::LOGIC_NOT_CONTAINS,
                'label' => __('Value Does Not Contain')
            ],
        ];
    }
}
