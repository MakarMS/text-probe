<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\DhlExpress10Probe;

/**
 * @internal
 */
class DhlExpress10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new DhlExpress10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::DHL_EXPRESS_10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['1234567890'],
            ['0000000001'],
            ['1111111111'],
            ['9876543210'],
            ['5555555555'],
            ['2222222222'],
            ['3333333333'],
            ['4444444444'],
            ['6666666666'],
            ['7777777777'],
        ];
    }
}
