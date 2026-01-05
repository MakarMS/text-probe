<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\LaPosteColissimoS10Probe;

/**
 * @internal
 */
class LaPosteColissimoS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new LaPosteColissimoS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::LA_POSTE_COLISSIMO_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('LA', '00000000', 'FR')],
            [TrackingTestHelper::makeS10('LA', '11111111', 'FR')],
            [TrackingTestHelper::makeS10('LA', '12345678', 'FR')],
            [TrackingTestHelper::makeS10('LA', '87654321', 'FR')],
            [TrackingTestHelper::makeS10('LA', '23456789', 'FR')],
            [TrackingTestHelper::makeS10('LA', '98765432', 'FR')],
            [TrackingTestHelper::makeS10('LA', '55555555', 'FR')],
            [TrackingTestHelper::makeS10('LA', '13579135', 'FR')],
            [TrackingTestHelper::makeS10('LA', '24680246', 'FR')],
            [TrackingTestHelper::makeS10('LA', '10293847', 'FR')],
        ];
    }
}
