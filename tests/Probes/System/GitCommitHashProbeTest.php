<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitCommitHashProbe;

/**
 * @internal
 */
class GitCommitHashProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GitCommitHashProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_COMMIT_HASH, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['abcdef1', 7],
            ['1234567', 7],
            ['deadbee', 7],
            ['feed1234', 8],
            ['cafebabe1', 9],
            ['0f0f0f0f', 8],
            ['a1b2c3d4e5f', 11],
            ['abcdef123456', 12],
            ['0123456789abcdef0123456789abcdef01234567', 40],
            ['deadbeefdeadbeefdeadbeefdeadbeefdeadbeef', 40],
        ];
    }
}
