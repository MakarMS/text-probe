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
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new CorreosS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::CORREOS_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('CE', '00000000', 'ES')],
            [TrackingTestHelper::makeS10('CE', '11111111', 'ES')],
            [TrackingTestHelper::makeS10('CE', '12345678', 'ES')],
            [TrackingTestHelper::makeS10('CE', '87654321', 'ES')],
            [TrackingTestHelper::makeS10('CE', '23456789', 'ES')],
            [TrackingTestHelper::makeS10('CE', '98765432', 'ES')],
            [TrackingTestHelper::makeS10('CE', '55555555', 'ES')],
            [TrackingTestHelper::makeS10('CE', '13579135', 'ES')],
            [TrackingTestHelper::makeS10('CE', '24680246', 'ES')],
            [TrackingTestHelper::makeS10('CE', '10293847', 'ES')],
        ];
    }
}
