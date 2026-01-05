<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\PostnlTrackingProbe;

/**
 * @internal
 */
class PostnlTrackingProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new PostnlTrackingProbe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POSTNL_TRACKING, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            ['3S1234567890123'],
            ['3S0000000000001'],
            ['3S1111111111111'],
            ['3S9876543210987'],
            ['3S5555555555555'],
            ['3S2222222222222'],
            ['3S3333333333333'],
            ['3S4444444444444'],
            ['3S6666666666666'],
            ['3S7777777777777'],
        ];
    }
}
