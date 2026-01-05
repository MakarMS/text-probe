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
    public function testFindsMatches(string $value): void
    {
        $probe = new AbsolutePathProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::ABSOLUTE_PATH, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['/api/v1/users'],
            ['/health'],
            ['/assets/app.js'],
            ['/v1/resource/123'],
            ['/users/123/profile'],
            ['/files/report.pdf'],
            ['/search?q=test'],
            ['/path/with-dash'],
            ['/path_with_underscore'],
            ['/path/with~tilde'],
        ];
    }
}
