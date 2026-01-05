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
    public function testFindsMatches(string $value): void
    {
        $probe = new EnvVariableProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::ENV_VARIABLE, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['PATH'],
            ['HOME'],
            ['DEBUG'],
            ['PORT'],
            ['API_KEY'],
            ['DATABASE_URL'],
            ['NODE_ENV'],
            ['LOG_LEVEL'],
            ['FEATURE_FLAG'],
            ['SERVICE_NAME'],
        ];
    }
}
