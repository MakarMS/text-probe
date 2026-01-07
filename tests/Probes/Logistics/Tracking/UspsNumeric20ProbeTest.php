<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\UspsNumeric20Probe;

/**
 * @internal
 */
class UspsNumeric20ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new UspsNumeric20Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }
    public function testFindsMatchAtStartLine(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
NEXTLINE";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }

    public function testFindsMatchAtEndLine(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "FIRSTLINE
" . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }

    public function testFindsMatchWithSurroundingLines(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "HEADER
" . $trackingNumber . "
FOOTER";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }

    public function testFindsMatchWithTrailingNewline(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];
        $secondTrackingNumber = self::validTrackingNumbers()[1][0];

        $text = $trackingNumber . "
" . $secondTrackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());

        $this->assertSame($secondTrackingNumber, $results[1]->getResult());
        $this->assertSame(strpos($text, $secondTrackingNumber), $results[1]->getStart());
        $this->assertSame($results[1]->getStart() + strlen($secondTrackingNumber), $results[1]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[1]->getProbeType());
    }

    public function testFindsDuplicateMatches(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
" . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstPos = strpos($text, $trackingNumber);
        $secondPos = strpos($text, $trackingNumber, $firstPos + 1);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame($firstPos, $results[0]->getStart());
        $this->assertSame($firstPos + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame($secondPos, $results[1]->getStart());
        $this->assertSame($secondPos + strlen($trackingNumber), $results[1]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[1]->getProbeType());
    }

    public function testIgnoresEmbeddedText(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'Track ' . $trackingNumber . ' here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresExtraCharacters(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . 'X';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMatchWithBlankLines(): void
    {
        $probe = new UspsNumeric20Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "
" . $trackingNumber . "
";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(1, $results[0]->getStart());
        $this->assertSame(1 + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }


    public static function validTrackingNumbers(): array
    {
        return [
            ['92055901649173141010'],
            ['94055000000000000000'],
            ['92748999999999999999'],
            ['95055012345678901234'],
            ['93033098765432109876'],
            ['91020222222222222222'],
            ['92055933333333333333'],
            ['94001144444444444444'],
            ['92748955555555555555'],
            ['95055166666666666666'],
        ];
    }
}
