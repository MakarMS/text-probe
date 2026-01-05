<?php

namespace Tests\Probes\Logistics\Tracking;

use PHPUnit\Framework\TestCase;
use Tests\Support\TrackingTestHelper;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\Tracking\PosteItalianeS10Probe;

/**
 * @internal
 */
class PosteItalianeS10ProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validTrackingNumbers')]
    public function testFindsMatches(string $trackingNumber): void
    {
        $probe = new PosteItalianeS10Probe();

        $results = $probe->probe($trackingNumber);

        $this->assertCount(1, $results);
        $this->assertSame($trackingNumber, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($trackingNumber), $results[0]->getEnd());
        $this->assertSame(ProbeType::POSTE_ITALIANE_S10, $results[0]->getProbeType());
    }

    public static function validTrackingNumbers(): array
    {
        return [
            [TrackingTestHelper::makeS10('PI', '00000000', 'IT')],
            [TrackingTestHelper::makeS10('PI', '11111111', 'IT')],
            [TrackingTestHelper::makeS10('PI', '12345678', 'IT')],
            [TrackingTestHelper::makeS10('PI', '87654321', 'IT')],
            [TrackingTestHelper::makeS10('PI', '23456789', 'IT')],
            [TrackingTestHelper::makeS10('PI', '98765432', 'IT')],
            [TrackingTestHelper::makeS10('PI', '55555555', 'IT')],
            [TrackingTestHelper::makeS10('PI', '13579135', 'IT')],
            [TrackingTestHelper::makeS10('PI', '24680246', 'IT')],
            [TrackingTestHelper::makeS10('PI', '10293847', 'IT')],
        ];
    }
}
