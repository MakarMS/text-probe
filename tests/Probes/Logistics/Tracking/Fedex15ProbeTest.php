<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\Fedex15Probe;

/**
 * @internal
 */
class Fedex15ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber, int $expectedEnd): void
    {
        $probe = new Fedex15Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['123456789012345', 15],
            ['000000000000001', 15],
            ['111111111111111', 15],
            ['987654321098765', 15],
            ['555555555555555', 15],
            ['222222222222222', 15],
            ['333333333333333', 15],
            ['444444444444444', 15],
            ['666666666666666', 15],
            ['777777777777777', 15],
        ];
    }

    public function testFindsMatchAtStartLine(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
NEXTLINE';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }

    public function testFindsMatchAtEndLine(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'FIRSTLINE
' . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(10, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }

    public function testFindsMatchWithSurroundingLines(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'HEADER
' . $trackingNumber . '
FOOTER';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }

    public function testFindsMatchWithTrailingNewline(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];
        $secondTrackingNumber = self::validTrackingNumbers()[1][0];

        $text = $trackingNumber . '
' . $secondTrackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());

        $this->assertSame($secondTrackingNumber, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[1]->getProbeType());
    }

    public function testFindsDuplicateMatches(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
' . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[1]->getProbeType());
    }

    public function testIgnoresEmbeddedText(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'Track ' . $trackingNumber . ' here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresExtraCharacters(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . 'X';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMatchWithBlankLines(): void
    {
        $probe = new Fedex15Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = '
' . $trackingNumber . '
';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(1, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }
}
