<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\RoyalMailS10Probe;

/**
 * @internal
 */
class RoyalMailS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new RoyalMailS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::ROYAL_MAIL_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('RM', '00000000', 'GB')],
            [TrackingTestHelper::makeS10('RM', '11111111', 'GB')],
            [TrackingTestHelper::makeS10('RM', '12345678', 'GB')],
            [TrackingTestHelper::makeS10('RM', '87654321', 'GB')],
            [TrackingTestHelper::makeS10('RM', '23456789', 'GB')],
            [TrackingTestHelper::makeS10('RM', '98765432', 'GB')],
            [TrackingTestHelper::makeS10('RM', '55555555', 'GB')],
            [TrackingTestHelper::makeS10('RM', '13579135', 'GB')],
            [TrackingTestHelper::makeS10('RM', '24680246', 'GB')],
            [TrackingTestHelper::makeS10('RM', '10293847', 'GB')],
        ];
    }
}
