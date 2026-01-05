<?php

namespace Tests\Probes\Barcode;

use PHPUnit\Framework\TestCase;
use Tests\Support\BarcodeTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Barcode\BarcodeValueProbe;

/**
 * @internal
 */
class BarcodeValueProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('barcodeSamples')]
    public function testFindsMatches(string $text, string $expected): void
    {
        $probe = new BarcodeValueProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strpos($text, $expected), $results[0]->getStart());
        $this->assertSame(strpos($text, $expected) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::BARCODE_VALUE, $results[0]->getProbeType());
    }

    public static function barcodeSamples(): array
    {
        $eanBodies = [
            '400638133393',
            '590123412345',
            '123456789012',
            '987654321098',
            '000000000000',
        ];
        $upcBodies = [
            '03600029145',
            '01234567890',
            '12345678901',
            '98765432109',
            '00000000000',
        ];

        $cases = [];
        foreach ($eanBodies as $body) {
            $value = BarcodeTestHelper::makeEan13($body);
            $text = "Value:\n" . $value;
            $cases[] = [$text, $value];
        }
        foreach ($upcBodies as $body) {
            $value = BarcodeTestHelper::makeUpcA($body);
            $text = "Code:\n" . $value;
            $cases[] = [$text, $value];
        }

        return $cases;
    }
}
