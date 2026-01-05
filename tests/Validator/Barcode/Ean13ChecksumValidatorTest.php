<?php

namespace Tests\Validator\Barcode;

use PHPUnit\Framework\TestCase;
use Tests\Support\BarcodeTestHelper;
use TextProbe\Validator\Barcode\Ean13ChecksumValidator;

/**
 * @internal
 */
class Ean13ChecksumValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testValidatesChecksum(string $value, bool $expected): void
    {
        $validator = new Ean13ChecksumValidator();

        $this->assertSame($expected, $validator->validate($value));
    }

    public static function samples(): array
    {
        $bodies = [
            '400638133393',
            '590123412345',
            '123456789012',
            '987654321098',
            '000000000000',
            '111111111111',
            '222222222222',
            '333333333333',
            '444444444444',
            '555555555555',
        ];

        $valid = array_map(
            static fn (string $body) => BarcodeTestHelper::makeEan13($body),
            $bodies,
        );

        $invalid = array_map(
            static function (string $value): string {
                $last = (int) $value[12];
                $replacement = ($last + 1) % 10;

                return substr($value, 0, 12) . $replacement;
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
