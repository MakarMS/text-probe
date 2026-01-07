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
    public function testFindsMatches(string $text, string $barcode, int $start, int $end): void
    {
        $probe = new Ean13Probe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($barcode, $results[0]->getResult());
        $this->assertSame($start, $results[0]->getStart());
        $this->assertSame($end, $results[0]->getEnd());
        $this->assertSame(ProbeType::EAN_13, $results[0]->getProbeType());
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidSamples')]
    public function testFindsNoMatches(string $text): void
    {
        $probe = new Ean13Probe();

        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public static function validCodes(): array
    {
        $values = [
            BarcodeTestHelper::makeEan13('400638133393'),
            BarcodeTestHelper::makeEan13('590123412345'),
            BarcodeTestHelper::makeEan13('123456789012'),
            BarcodeTestHelper::makeEan13('987654321098'),
            BarcodeTestHelper::makeEan13('000000000000'),
            BarcodeTestHelper::makeEan13('111111111111'),
            BarcodeTestHelper::makeEan13('222222222222'),
            BarcodeTestHelper::makeEan13('333333333333'),
            BarcodeTestHelper::makeEan13('444444444444'),
            BarcodeTestHelper::makeEan13('555555555555'),
        ];

        return [
            [$values[0], $values[0], 0, 13],
            ["EAN {$values[1]}", $values[1], 4, 17],
            ["({$values[2]})", $values[2], 1, 14],
            ["Start{$values[3]}End", $values[3], 5, 18],
            ["{$values[4]}.", $values[4], 0, 13],
            ["value={$values[5]};", $values[5], 6, 19],
            ["{$values[6]}, next", $values[6], 0, 13],
            ["Text {$values[7]} text", $values[7], 5, 18],
            ["[{$values[8]}]", $values[8], 1, 14],
            ["{$values[9]}?", $values[9], 0, 13],
        ];
    }

    public static function invalidSamples(): array
    {
        $valid = BarcodeTestHelper::makeEan13('400638133393');
        $invalid = substr($valid, 0, -1) . ((int) substr($valid, -1) + 1) % 10;

        return [
            ['No EAN here.'],
            ["{$invalid} is wrong"],
            ['Digits 12345678901234 are too long'],
        ];
    }
}
