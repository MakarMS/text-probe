<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\HermesEvriTrackingProbe;

/**
 * @internal
 */
class HermesEvriTrackingProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new HermesEvriTrackingProbe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::HERMES_EVRI_TRACKING, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['H1234567890'],
            ['H0000000001'],
            ['H1111111111'],
            ['H9876543210'],
            ['H5555555555'],
            ['H2222222222'],
            ['H3333333333'],
            ['H4444444444'],
            ['H6666666666'],
            ['H7777777777'],
        ];
    }
}
