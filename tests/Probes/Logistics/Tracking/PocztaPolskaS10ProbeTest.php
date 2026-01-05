<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\PocztaPolskaS10Probe;

/**
 * @internal
 */
class PocztaPolskaS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new PocztaPolskaS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POCZTA_POLSKA_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('CP', '00000000', 'PL')],
            [TrackingTestHelper::makeS10('CP', '11111111', 'PL')],
            [TrackingTestHelper::makeS10('CP', '12345678', 'PL')],
            [TrackingTestHelper::makeS10('CP', '87654321', 'PL')],
            [TrackingTestHelper::makeS10('CP', '23456789', 'PL')],
            [TrackingTestHelper::makeS10('CP', '98765432', 'PL')],
            [TrackingTestHelper::makeS10('CP', '55555555', 'PL')],
            [TrackingTestHelper::makeS10('CP', '13579135', 'PL')],
            [TrackingTestHelper::makeS10('CP', '24680246', 'PL')],
            [TrackingTestHelper::makeS10('CP', '10293847', 'PL')],
        ];
    }
}
