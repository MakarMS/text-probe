<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\Fedex15Probe;

/**
 * @internal
 */
class Fedex15ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new Fedex15Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::FEDEX_15, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['123456789012345'],
            ['000000000000001'],
            ['111111111111111'],
            ['987654321098765'],
            ['555555555555555'],
            ['222222222222222'],
            ['333333333333333'],
            ['444444444444444'],
            ['666666666666666'],
            ['777777777777777'],
        ];
    }
}
