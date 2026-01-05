<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\SwissPostS10Probe;

/**
 * @internal
 */
class SwissPostS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new SwissPostS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::SWISS_POST_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('CH', '00000000', 'CH')],
            [TrackingTestHelper::makeS10('CH', '11111111', 'CH')],
            [TrackingTestHelper::makeS10('CH', '12345678', 'CH')],
            [TrackingTestHelper::makeS10('CH', '87654321', 'CH')],
            [TrackingTestHelper::makeS10('CH', '23456789', 'CH')],
            [TrackingTestHelper::makeS10('CH', '98765432', 'CH')],
            [TrackingTestHelper::makeS10('CH', '55555555', 'CH')],
            [TrackingTestHelper::makeS10('CH', '13579135', 'CH')],
            [TrackingTestHelper::makeS10('CH', '24680246', 'CH')],
            [TrackingTestHelper::makeS10('CH', '10293847', 'CH')],
        ];
    }
}
