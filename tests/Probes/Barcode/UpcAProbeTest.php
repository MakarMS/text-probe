<?php

namespace Tests\Probes\Barcode;

use PHPUnit\Framework\TestCase;
use Tests\Support\BarcodeTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Barcode\UpcAProbe;

/**
 * @internal
 */
class UpcAProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validCodes')]
    public function testFindsMatches(string $barcode): void
    {
        $probe = new UpcAProbe();

        $results = $probe->probe($barcode);

        $this->assertCount(1, $results);
        $this->assertSame($barcode, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($barcode), $results[0]->getEnd());
        $this->assertSame(ProbeType::UPC_A, $results[0]->getProbeType());
    }

    public static function validCodes(): array
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

        return array_map(
            static fn (string $body) => [BarcodeTestHelper::makeUpcA($body)],
            $bodies,
        );
    }
}
