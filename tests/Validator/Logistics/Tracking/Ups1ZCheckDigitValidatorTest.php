<?php

namespace Tests\Validator\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Validator\Logistics\Tracking\Ups1ZCheckDigitValidator;

/**
 * @internal
 */
class Ups1ZCheckDigitValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('trackingNumbers')]
    public function testValidatesCheckDigit(string $trackingNumber, bool $expected): void
    {
        $validator = new Ups1ZCheckDigitValidator();

        $this->assertSame($expected, $validator->validate($trackingNumber));
    }

    public static function trackingNumbers(): array
    {
        $bodies = [
            '1Z12345E020527168',
            '1Z999AA101234567B',
            '1Z00000E020000000',
            '1ZABCDE1234567890',
            '1Z1A2B3C4D5E6F7G8',
            '1Z9Z8Y7X6W5V4U3T1',
            '1Z13579A2468B1357',
            '1Z24680C1357D2468',
            '1ZABCDEABCDEABCDE',
            '1Z11111E22222F333',
        ];

        $valid = array_map(
            static fn (string $body) => TrackingTestHelper::makeUps1Z($body),
            $bodies,
        );

        $invalid = array_map(
            static function (string $trackingNumber): string {
                $last = substr($trackingNumber, -1);
                $replacement = ((int) $last + 1) % 10;

                return substr($trackingNumber, 0, -1) . $replacement;
            },
            $valid,
        );

        $cases = [];
        foreach ($valid as $trackingNumber) {
            $cases[] = [$trackingNumber, true];
        }
        foreach ($invalid as $trackingNumber) {
            $cases[] = [$trackingNumber, false];
        }

        return $cases;
    }
}
