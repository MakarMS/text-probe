<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\EnvAssignmentProbe;

/**
 * @internal
 */
class EnvAssignmentProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new EnvAssignmentProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::ENV_ASSIGNMENT, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['PATH=/usr/bin', 13],
            ['HOME=/home/user', 15],
            ['DEBUG=true', 10],
            ['PORT=8080', 9],
            ['API_KEY=abc123', 14],
            ['EMPTY=', 6],
            ['DATABASE_URL=postgres://localhost/db', 36],
            ['NODE_ENV=production', 19],
            ['LOG_LEVEL=info', 14],
            ['FEATURE_FLAG=enabled', 20],
        ];
    }
}
