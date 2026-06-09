<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\CircleciWorkflowUuidProbe;

/**
 * @internal
 */
class CircleciWorkflowUuidProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new CircleciWorkflowUuidProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CIRCLECI_WORKFLOW_UUID, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['550e8400-e29b-41d4-a716-446655440000', 36],
            ['123e4567-e89b-12d3-a456-426614174000', 36],
            ['6f1c2b3a-4d5e-6f70-8a9b-0c1d2e3f4a5b', 36],
            ['aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee', 36],
            ['11111111-2222-3333-4444-555555555555', 36],
            ['abcdefab-cdef-abcd-efab-cdefabcdefab', 36],
            ['0f0f0f0f-0f0f-0f0f-0f0f-0f0f0f0f0f0f', 36],
            ['99999999-8888-7777-6666-555555555555', 36],
            ['deadbeef-dead-beef-dead-beefdeadbeef', 36],
            ['cafebabe-cafe-babe-cafe-babecafebabe', 36],
        ];
    }
}
