<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\UspsNumeric22Probe;

/**
 * @internal
 */
class UspsNumeric22ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber, int $expectedEnd): void
    {
        $probe = new UspsNumeric22Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['9205590164917314101012', 22],
            ['9405500000000000000000', 22],
            ['9274899999999999999999', 22],
            ['9505501234567890123456', 22],
            ['9303309876543210987654', 22],
            ['9102022222222222222222', 22],
            ['9205593333333333333333', 22],
            ['9400114444444444444444', 22],
            ['9274895555555555555555', 22],
            ['9505516666666666666666', 22],
        ];
    }

    public function testFindsMatchAtStartLine(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
NEXTLINE';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }

    public function testFindsMatchAtEndLine(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'FIRSTLINE
' . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(10, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }

    public function testFindsMatchWithSurroundingLines(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'HEADER
' . $trackingNumber . '
FOOTER';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }

    public function testFindsMatchWithTrailingNewline(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];
        $secondTrackingNumber = self::validTrackingNumbers()[1][0];

        $text = $trackingNumber . '
' . $secondTrackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());

        $this->assertSame($secondTrackingNumber, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(45, $results[1]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[1]->getProbeType());
    }

    public function testFindsDuplicateMatches(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
' . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(45, $results[1]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[1]->getProbeType());
    }

    public function testIgnoresEmbeddedText(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'Track ' . $trackingNumber . ' here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresExtraCharacters(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . 'X';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMatchWithBlankLines(): void
    {
        $probe = new UspsNumeric22Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = '
' . $trackingNumber . '
';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(1, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }
}
