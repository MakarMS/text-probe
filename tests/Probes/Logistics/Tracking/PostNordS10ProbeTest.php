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
