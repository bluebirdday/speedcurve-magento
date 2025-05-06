<?php

declare(strict_types=1);

namespace Bluebirdday\SpeedcurveMagento\Test\Unit\Model\Config\Source;

use Bluebirdday\SpeedcurveMagento\Model\Config\Source\ConsentLogic;
use PHPUnit\Framework\TestCase;

/**
 * Class ConsentLogicTest.
 */
final class ConsentLogicTest extends TestCase
{
    /**
     * Test method 'toOptionArray'.
     */
    public function testToOptionArray(): void
    {
        $consentLogic = new ConsentLogic();
        $options = $consentLogic->toOptionArray();

        if (count($options) === 0) {
            self::markTestSkipped('No options to validate');
        }

        foreach ($options as $option) {
            self::assertIsArray($option);
            self::assertArrayHasKey('label', $option);
            self::assertArrayHasKey('value', $option);
        }
    }
}
