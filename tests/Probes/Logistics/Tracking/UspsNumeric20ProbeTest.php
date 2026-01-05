<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\UspsNumeric20Probe;

/**
 * @internal
 */
class UspsNumeric20ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new UspsNumeric20Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::USPS_NUMERIC_20, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['92055901649173141010'],
            ['94055000000000000000'],
            ['92748999999999999999'],
            ['95055012345678901234'],
            ['93033098765432109876'],
            ['91020222222222222222'],
            ['92055933333333333333'],
            ['94001144444444444444'],
            ['92748955555555555555'],
            ['95055166666666666666'],
        ];
    }
}
