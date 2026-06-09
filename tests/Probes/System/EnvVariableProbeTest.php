<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\EnvVariableProbe;

/**
 * @internal
 */
class EnvVariableProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new EnvVariableProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::ENV_VARIABLE, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['PATH', 4],
            ['HOME', 4],
            ['DEBUG', 5],
            ['PORT', 4],
            ['API_KEY', 7],
            ['DATABASE_URL', 12],
            ['NODE_ENV', 8],
            ['LOG_LEVEL', 9],
            ['FEATURE_FLAG', 12],
            ['SERVICE_NAME', 12],
        ];
    }
}
