<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\PostNordS10Probe;

/**
 * @internal
 */
class PostNordS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new PostNordS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());
    }
    public function testFindsMatchAtStartLine(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
NEXTLINE";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchAtEndLine(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "FIRSTLINE
" . $trackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchWithSurroundingLines(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "HEADER
" . $trackingNumber . "
FOOTER";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(strpos($text, $trackingNumber), $results[0]->getStart());
        $this->assertSame($results[0]->getStart() + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());
    }

    public function testFindsMatchWithTrailingNewline(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . "
";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];
        $secondTrackingNumber = self::validTrackingNumbers()[1][0];

        $text = $trackingNumber . "
" . $secondTrackingNumber;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());

        $this->assertSame($secondTrackingNumber, $results[1]->getResult());
        $this->assertSame(strpos($text, $secondTrackingNumber), $results[1]->getStart());
        $this->assertSame($results[1]->getStart() + strlen($secondTrackingNumber), $results[1]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[1]->getProbeType());
    }

    public function testFindsDuplicateMatches(): void
    {
        $probe = new PostNordS10Probe();
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
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());

        $this->assertSame($trackingNumber, $results[1]->getResult());
        $this->assertSame($secondPos, $results[1]->getStart());
        $this->assertSame($secondPos + strlen($trackingNumber), $results[1]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[1]->getProbeType());
    }

    public function testIgnoresEmbeddedText(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = 'Track ' . $trackingNumber . ' here';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresExtraCharacters(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = $trackingNumber . 'X';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMatchWithBlankLines(): void
    {
        $probe = new PostNordS10Probe();
        $trackingNumber = self::validTrackingNumbers()[0][0];

        $text = "
" . $trackingNumber . "
";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(1, $results[0]->getStart());
        $this->assertSame(1 + strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POST_NORD_S10, $results[0]->getProbeType());
    }


    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('PN', '00000000', 'SE')],
            [TrackingTestHelper::makeS10('PN', '11111111', 'NO')],
            [TrackingTestHelper::makeS10('PN', '12345678', 'DK')],
            [TrackingTestHelper::makeS10('PN', '87654321', 'FI')],
            [TrackingTestHelper::makeS10('PN', '23456789', 'SE')],
            [TrackingTestHelper::makeS10('PN', '98765432', 'NO')],
            [TrackingTestHelper::makeS10('PN', '55555555', 'DK')],
            [TrackingTestHelper::makeS10('PN', '13579135', 'FI')],
            [TrackingTestHelper::makeS10('PN', '24680246', 'SE')],
            [TrackingTestHelper::makeS10('PN', '10293847', 'NO')],
        ];
    }
}
