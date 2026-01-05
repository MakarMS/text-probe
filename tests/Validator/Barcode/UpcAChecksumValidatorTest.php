<?php

namespace Tests\Validator\Barcode;

use PHPUnit\Framework\TestCase;
use Tests\Support\BarcodeTestHelper;
use TextProbe\Validator\Barcode\UpcAChecksumValidator;

/**
 * @internal
 */
class UpcAChecksumValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testValidatesChecksum(string $value, bool $expected): void
    {
        $validator = new UpcAChecksumValidator();

        $this->assertSame($expected, $validator->validate($value));
    }

    public static function samples(): array
    {
        $bodies = [
            '03600029145',
            '01234567890',
            '12345678901',
            '98765432109',
            '00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
        ];

        $valid = array_map(
            static fn (string $body) => BarcodeTestHelper::makeUpcA($body),
            $bodies,
        );

        $invalid = array_map(
            static function (string $value): string {
                $last = (int) $value[11];
                $replacement = ($last + 1) % 10;

                return substr($value, 0, 11) . $replacement;
            },
            $valid,
        );

        $cases = [];
        foreach ($valid as $value) {
            $cases[] = [$value, true];
        }
        foreach ($invalid as $value) {
            $cases[] = [$value, false];
        }

        return $cases;
    }
}
