<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\CorreosS10Probe;

/**
 * @internal
 */
class CorreosS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber, int $expectedEnd): void
    {
        $probe = new CorreosS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('CE', '00000000', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '11111111', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '12345678', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '87654321', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '23456789', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '98765432', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '55555555', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '13579135', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '24680246', 'ES'), 13],
            [TrackingTestHelper::makeS10('CE', '10293847', 'ES'), 13],
        ];
    }

    public function testFindsMatchAtStartLine(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
NEXTLINE';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchAtEndLine(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'FIRSTLINE
' . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(10, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchWithSurroundingLines(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'HEADER
' . $trackingNumber . '
FOOTER';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchWithTrailingNewline(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];
        $secondTrackingNumber = self::validTrackingNumbers()[1][0];

        $text = $trackingNumber . '
' . $secondTrackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());

        $this->assertSame($secondTrackingNumber, $results[1]->getResult());
        $this->assertSame(14, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[1]->getProbeType());
    }

    public function testFindsDuplicateMatches(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . '
' . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame(14, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[1]->getProbeType());
    }

    public function testIgnoresEmbeddedText(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'Track ' . $trackingNumber . ' here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresExtraCharacters(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . 'X';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMatchWithBlankLines(): void
    {
        $probe = new CorreosS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = '
' . $trackingNumber . '
';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(1, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }
}
