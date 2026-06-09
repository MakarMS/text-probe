<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitFullShaProbe;

/**
 * @internal
 */
class GitFullShaProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GitFullShaProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_FULL_SHA, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 40],
            ['bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 40],
            ['cccccccccccccccccccccccccccccccccccccccc', 40],
            ['dddddddddddddddddddddddddddddddddddddddd', 40],
            ['eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 40],
            ['ffffffffffffffffffffffffffffffffffffffff', 40],
            ['0123456789abcdef0123456789abcdef01234567', 40],
            ['abcdefabcdefabcdefabcdefabcdefabcdefabcd', 40],
            ['1234567890abcdef1234567890abcdef12345678', 40],
            ['deadbeefdeadbeefdeadbeefdeadbeefdeadbeef', 40],
        ];
    }
}
