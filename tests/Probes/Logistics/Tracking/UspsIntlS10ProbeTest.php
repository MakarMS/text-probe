<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\UspsIntlS10Probe;

/**
 * @internal
 */
class UspsIntlS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new UspsIntlS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_INTL_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('RA', '00000000', 'US')],
            [TrackingTestHelper::makeS10('RA', '11111111', 'US')],
            [TrackingTestHelper::makeS10('RA', '12345678', 'US')],
            [TrackingTestHelper::makeS10('RA', '87654321', 'US')],
            [TrackingTestHelper::makeS10('RA', '23456789', 'US')],
            [TrackingTestHelper::makeS10('RA', '98765432', 'US')],
            [TrackingTestHelper::makeS10('RA', '55555555', 'US')],
            [TrackingTestHelper::makeS10('RA', '13579135', 'US')],
            [TrackingTestHelper::makeS10('RA', '24680246', 'US')],
            [TrackingTestHelper::makeS10('RA', '10293847', 'US')],
        ];
    }
}
