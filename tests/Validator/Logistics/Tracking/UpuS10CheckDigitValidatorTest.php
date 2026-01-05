<?php

namespace Tests\Validator\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * @internal
 */
class UpuS10CheckDigitValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('trackingNumbers')]
    public function testValidatesCheckDigit(string $trackingNumber, bool $expected): void
    {
        $validator = new UpuS10CheckDigitValidator();

        $this->assertSame($expected, $validator->validate($trackingNumber));
    }

    public static function trackingNumbers(): array
    {
        $entries = [
            ['RA', '00000000', 'US'],
            ['RM', '11111111', 'GB'],
            ['LA', '12345678', 'FR'],
            ['CE', '87654321', 'ES'],
            ['BP', '23456789', 'BE'],
            ['DE', '98765432', 'DE'],
            ['CH', '55555555', 'CH'],
            ['PI', '13579135', 'IT'],
            ['CP', '24680246', 'PL'],
            ['PN', '10293847', 'SE'],
        ];

        $valid = array_map(
            static fn (array $entry) => TrackingTestHelper::makeS10($entry[0], $entry[1], $entry[2]),
            $entries,
        );

        $invalid = array_map(
            static function (string $trackingNumber): string {
                $checkDigit = (int) $trackingNumber[10];
                $replacement = ($checkDigit + 1) % 10;

                return substr($trackingNumber, 0, 10) . $replacement . substr($trackingNumber, 11);
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
