<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\DpdTrackingProbe;

/**
 * @internal
 */
class DpdTrackingProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new DpdTrackingProbe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::DPD_TRACKING, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['12345678901234'],
            ['00000000000001'],
            ['11111111111111'],
            ['98765432109876'],
            ['55555555555555'],
            ['22222222222222'],
            ['33333333333333'],
            ['44444444444444'],
            ['66666666666666'],
            ['77777777777777'],
        ];
    }
}
