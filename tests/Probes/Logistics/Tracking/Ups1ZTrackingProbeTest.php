<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\Ups1ZTrackingProbe;

/**
 * @internal
 */
class Ups1ZTrackingProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new Ups1ZTrackingProbe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::UPS_1Z_TRACKING, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        $bodies = [
            '1Z12345E020527168',
            '1Z999AA101234567B',
            '1Z00000E020000000',
            '1ZABCDE1234567890',
            '1Z1A2B3C4D5E6F7G8',
            '1Z9Z8Y7X6W5V4U3T1',
            '1Z13579A2468B1357',
            '1Z24680C1357D2468',
            '1ZABCDEABCDEABCDE',
            '1Z11111E22222F333',
        ];

        return array_map(
            static fn (string $body) => [TrackingTestHelper::makeUps1Z($body)],
            $bodies,
        );
    }
}
