<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\AbsolutePathProbe;

/**
 * @internal
 */
class AbsolutePathProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new AbsolutePathProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::ABSOLUTE_PATH, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['/api/v1/users', 13],
            ['/health', 7],
            ['/assets/app.js', 14],
            ['/v1/resource/123', 16],
            ['/users/123/profile', 18],
            ['/files/report.pdf', 17],
            ['/search?q=test', 14],
            ['/path/with-dash', 15],
            ['/path_with_underscore', 21],
            ['/path/with~tilde', 16],
        ];
    }
}
