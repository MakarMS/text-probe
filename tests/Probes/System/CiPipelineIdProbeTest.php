<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\CiPipelineIdProbe;

/**
 * @internal
 */
class CiPipelineIdProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new CiPipelineIdProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::CI_PIPELINE_ID, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['1'],
            ['42'],
            ['123'],
            ['999'],
            ['1000'],
            ['54321'],
            ['987654'],
            ['314159'],
            ['271828'],
            ['808080'],
        ];
    }
}
