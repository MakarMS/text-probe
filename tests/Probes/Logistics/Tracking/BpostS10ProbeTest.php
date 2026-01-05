<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\BpostS10Probe;

/**
 * @internal
 */
class BpostS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new BpostS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::BPOST_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('BP', '00000000', 'BE')],
            [TrackingTestHelper::makeS10('BP', '11111111', 'BE')],
            [TrackingTestHelper::makeS10('BP', '12345678', 'BE')],
            [TrackingTestHelper::makeS10('BP', '87654321', 'BE')],
            [TrackingTestHelper::makeS10('BP', '23456789', 'BE')],
            [TrackingTestHelper::makeS10('BP', '98765432', 'BE')],
            [TrackingTestHelper::makeS10('BP', '55555555', 'BE')],
            [TrackingTestHelper::makeS10('BP', '13579135', 'BE')],
            [TrackingTestHelper::makeS10('BP', '24680246', 'BE')],
            [TrackingTestHelper::makeS10('BP', '10293847', 'BE')],
        ];
    }
}
