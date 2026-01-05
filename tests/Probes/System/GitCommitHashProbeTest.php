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
    public function testFindsMatches(string $value): void
    {
        $probe = new GitCommitHashProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_COMMIT_HASH, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['abcdef1'],
            ['1234567'],
            ['deadbee'],
            ['feed1234'],
            ['cafebabe1'],
            ['0f0f0f0f'],
            ['a1b2c3d4e5f'],
            ['abcdef123456'],
            ['0123456789abcdef0123456789abcdef01234567'],
            ['deadbeefdeadbeefdeadbeefdeadbeefdeadbeef'],
        ];
    }
}
