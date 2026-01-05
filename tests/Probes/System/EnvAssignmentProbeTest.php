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
    public function testFindsMatches(string $value): void
    {
        $probe = new EnvAssignmentProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::ENV_ASSIGNMENT, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['PATH=/usr/bin'],
            ['HOME=/home/user'],
            ['DEBUG=true'],
            ['PORT=8080'],
            ['API_KEY=abc123'],
            ['EMPTY='],
            ['DATABASE_URL=postgres://localhost/db'],
            ['NODE_ENV=production'],
            ['LOG_LEVEL=info'],
            ['FEATURE_FLAG=enabled'],
        ];
    }
}
