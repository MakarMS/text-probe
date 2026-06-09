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
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new CiPipelineIdProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CI_PIPELINE_ID, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['1', 1],
            ['42', 2],
            ['123', 3],
            ['999', 3],
            ['1000', 4],
            ['54321', 5],
            ['987654', 6],
            ['314159', 6],
            ['271828', 6],
            ['808080', 6],
        ];
    }
}
