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
    public function testFindsMatches(string $text, string $barcode, int $start, int $end): void
    {
        $probe = new UpcAProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($barcode, $results[0]->getResult());
        $this->assertSame($start, $results[0]->getStart());
        $this->assertSame($end, $results[0]->getEnd());
        $this->assertSame(ProbeType::UPC_A, $results[0]->getProbeType());
    }

    public static function validCodes(): array
    {
        $values = [
            BarcodeTestHelper::makeUpcA('03600029145'),
            BarcodeTestHelper::makeUpcA('01234567890'),
            BarcodeTestHelper::makeUpcA('12345678901'),
            BarcodeTestHelper::makeUpcA('98765432109'),
            BarcodeTestHelper::makeUpcA('00000000000'),
            BarcodeTestHelper::makeUpcA('11111111111'),
            BarcodeTestHelper::makeUpcA('22222222222'),
            BarcodeTestHelper::makeUpcA('33333333333'),
            BarcodeTestHelper::makeUpcA('44444444444'),
            BarcodeTestHelper::makeUpcA('55555555555'),
        ];

        return [
            [$values[0], $values[0], 0, 12],
            ["UPC {$values[1]}", $values[1], 4, 16],
            ["({$values[2]})", $values[2], 1, 13],
            ["Start{$values[3]}End", $values[3], 5, 17],
            ["{$values[4]}.", $values[4], 0, 12],
            ["value={$values[5]};", $values[5], 6, 18],
            ["{$values[6]}, next", $values[6], 0, 12],
            ["Text {$values[7]} text", $values[7], 5, 17],
            ["[{$values[8]}]", $values[8], 1, 13],
            ["{$values[9]}?", $values[9], 0, 12],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidSamples')]
    public function testFindsNoMatches(string $text): void
    {
        $probe = new UpcAProbe();

        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public static function invalidSamples(): array
    {
        $valid = BarcodeTestHelper::makeUpcA('03600029145');
        $invalid = substr($valid, 0, -1) . ((int) substr($valid, -1) + 1) % 10;

        return [
            ['No UPC here.'],
            ["{$invalid} is wrong"],
            ['Digits 1234567890123 are too long'],
        ];
    }
}
