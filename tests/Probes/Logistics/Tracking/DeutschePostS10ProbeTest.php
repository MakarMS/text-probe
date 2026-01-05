<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\DeutschePostS10Probe;

/**
 * @internal
 */
class DeutschePostS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new DeutschePostS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::DEUTSCHE_POST_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('DE', '00000000', 'DE')],
            [TrackingTestHelper::makeS10('DE', '11111111', 'DE')],
            [TrackingTestHelper::makeS10('DE', '12345678', 'DE')],
            [TrackingTestHelper::makeS10('DE', '87654321', 'DE')],
            [TrackingTestHelper::makeS10('DE', '23456789', 'DE')],
            [TrackingTestHelper::makeS10('DE', '98765432', 'DE')],
            [TrackingTestHelper::makeS10('DE', '55555555', 'DE')],
            [TrackingTestHelper::makeS10('DE', '13579135', 'DE')],
            [TrackingTestHelper::makeS10('DE', '24680246', 'DE')],
            [TrackingTestHelper::makeS10('DE', '10293847', 'DE')],
        ];
    }
}
