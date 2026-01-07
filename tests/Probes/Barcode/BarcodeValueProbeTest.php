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
    public function testFindsMatches(string $text, string $expected, int $start, int $end): void
    {
        $probe = new BarcodeValueProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($start, $results[0]->getStart());
        $this->assertSame($end, $results[0]->getEnd());
        $this->assertSame(ProbeType::BARCODE_VALUE, $results[0]->getProbeType());
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidSamples')]
    public function testFindsNoMatches(string $text): void
    {
        $probe = new BarcodeValueProbe();

        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public static function barcodeSamples(): array
    {
        $eanValues = [
            BarcodeTestHelper::makeEan13('400638133393'),
            BarcodeTestHelper::makeEan13('590123412345'),
            BarcodeTestHelper::makeEan13('123456789012'),
            BarcodeTestHelper::makeEan13('987654321098'),
            BarcodeTestHelper::makeEan13('000000000000'),
        ];
        $upcValues = [
            BarcodeTestHelper::makeUpcA('03600029145'),
            BarcodeTestHelper::makeUpcA('01234567890'),
            BarcodeTestHelper::makeUpcA('12345678901'),
            BarcodeTestHelper::makeUpcA('98765432109'),
            BarcodeTestHelper::makeUpcA('00000000000'),
        ];

        return [
            ["Value: {$eanValues[0]}.", $eanValues[0], 7, 20],
            ["({$eanValues[1]})", $eanValues[1], 1, 14],
            ["EAN {$eanValues[2]} end", $eanValues[2], 4, 17],
            ["Start{$eanValues[3]}Middle", $eanValues[3], 5, 18],
            ["{$eanValues[4]}, next line", $eanValues[4], 0, 13],
            ["UPC: {$upcValues[0]}!", $upcValues[0], 5, 17],
            ["code={$upcValues[1]};", $upcValues[1], 5, 17],
            ["Text {$upcValues[2]} text", $upcValues[2], 5, 17],
            ["[{$upcValues[3]}]", $upcValues[3], 1, 13],
            ["{$upcValues[4]}?", $upcValues[4], 0, 12],
        ];
    }

    public static function invalidSamples(): array
    {
        $validEan = BarcodeTestHelper::makeEan13('400638133393');
        $invalidEan = substr($validEan, 0, -1) . ((int) substr($validEan, -1) + 1) % 10;
        $validUpc = BarcodeTestHelper::makeUpcA('03600029145');
        $invalidUpc = substr($validUpc, 0, -1) . ((int) substr($validUpc, -1) + 1) % 10;

        return [
            ['No barcode here.'],
            ["{$invalidEan} in text"],
            ["{$invalidUpc} is not valid"],
            ['Digits 12345678901234 are too long'],
        ];
    }
}
