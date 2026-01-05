<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\RussiaPostS10Probe;

/**
 * @internal
 */
class RussiaPostS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new RussiaPostS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::RUSSIA_POST_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('RA', '00000000', 'RU')],
            [TrackingTestHelper::makeS10('RA', '11111111', 'RU')],
            [TrackingTestHelper::makeS10('RA', '12345678', 'RU')],
            [TrackingTestHelper::makeS10('RA', '87654321', 'RU')],
            [TrackingTestHelper::makeS10('RA', '23456789', 'RU')],
            [TrackingTestHelper::makeS10('RA', '98765432', 'RU')],
            [TrackingTestHelper::makeS10('RA', '55555555', 'RU')],
            [TrackingTestHelper::makeS10('RA', '13579135', 'RU')],
            [TrackingTestHelper::makeS10('RA', '24680246', 'RU')],
            [TrackingTestHelper::makeS10('RA', '10293847', 'RU')],
        ];
    }
}
