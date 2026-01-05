<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\Fedex20Probe;

/**
 * @internal
 */
class Fedex20ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new Fedex20Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_20, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['12345678901234567890'],
            ['00000000000000000001'],
            ['11111111111111111111'],
            ['98765432109876543210'],
            ['55555555555555555555'],
            ['22222222222222222222'],
            ['33333333333333333333'],
            ['44444444444444444444'],
            ['66666666666666666666'],
            ['77777777777777777777'],
        ];
    }
}
