<?php

namespace Tests\Probes\Barcode;

use PHPUnit\Framework\TestCase;
use Tests\Support\BarcodeTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Barcode\Ean13Probe;

/**
 * @internal
 */
class Ean13ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validCodes')]
    public function testFindsMatches(string $barcode): void
    {
        $probe = new Ean13Probe();

        $results = $probe->probe($barcode);

        $this->assertCount(1, $results);
        $this->assertSame($barcode, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($barcode), $results[0]->getEnd());
        $this->assertSame(ProbeType::EAN_13, $results[0]->getProbeType());
    }

    public static function validCodes(): array
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

        return array_map(
            static fn (string $body) => [BarcodeTestHelper::makeEan13($body)],
            $bodies,
        );
    }
}
