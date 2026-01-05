<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\GlsTrackingProbe;

/**
 * @internal
 */
class GlsTrackingProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new GlsTrackingProbe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::GLS_TRACKING, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['12345678901'],
            ['000000000001'],
            ['111111111111'],
            ['9876543210987'],
            ['55555555555'],
            ['2222222222222'],
            ['333333333333'],
            ['4444444444444'],
            ['666666666666'],
            ['7777777777777'],
        ];
    }
}
