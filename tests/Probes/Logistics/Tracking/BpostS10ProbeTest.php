<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\BpostS10Probe;

/**
 * @internal
 */
class BpostS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new BpostS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }
    public function testFindsMatchAtStartLine(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
NEXTLINE";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchAtEndLine(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "FIRSTLINE
" . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchWithSurroundingLines(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "HEADER
" . $trackingNumber . "
FOOTER";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchWithTrailingNewline(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];
        $secondTrackingNumber = self::validTrackingNumbers()[1][0];

        $text = $trackingNumber . "
" . $secondTrackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());

        $this->assertSame($secondTrackingNumber, $results[1]->getResult());
        $this->assertSame(strpos($text, $secondTrackingNumber), $results[1]->getStart());
        $this->assertSame($results[1]->getStart() + strlen($secondTrackingNumber), $results[1]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[1]->getProbeType());
    }

    public function testFindsDuplicateMatches(): void
    {
        $probe = new BpostS10Probe();
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
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame($secondPos, $results[1]->getStart());
        $this->assertSame($secondPos + strlen($trackingNumber), $results[1]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[1]->getProbeType());
    }

    public function testIgnoresEmbeddedText(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'Track ' . $trackingNumber . ' here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresExtraCharacters(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . 'X';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMatchWithBlankLines(): void
    {
        $probe = new BpostS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "
" . $trackingNumber . "
";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(1, $results[0]->getStart());
        $this->assertSame(1 + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }


    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('BP', '00000000', 'BE')],
            [TrackingTestHelper::makeS10('BP', '11111111', 'BE')],
            [TrackingTestHelper::makeS10('BP', '12345678', 'BE')],
            [TrackingTestHelper::makeS10('BP', '87654321', 'BE')],
            [TrackingTestHelper::makeS10('BP', '23456789', 'BE')],
            [TrackingTestHelper::makeS10('BP', '98765432', 'BE')],
            [TrackingTestHelper::makeS10('BP', '55555555', 'BE')],
            [TrackingTestHelper::makeS10('BP', '13579135', 'BE')],
            [TrackingTestHelper::makeS10('BP', '24680246', 'BE')],
            [TrackingTestHelper::makeS10('BP', '10293847', 'BE')],
        ];
    }
}
