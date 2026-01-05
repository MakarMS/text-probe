<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\UspsNumeric22Probe;

/**
 * @internal
 */
class UspsNumeric22ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new UspsNumeric22Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_22, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['9205590164917314101012'],
            ['9405500000000000000000'],
            ['9274899999999999999999'],
            ['9505501234567890123456'],
            ['9303309876543210987654'],
            ['9102022222222222222222'],
            ['9205593333333333333333'],
            ['9400114444444444444444'],
            ['9274895555555555555555'],
            ['9505516666666666666666'],
        ];
    }
}
