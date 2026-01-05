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
    public function testFindsMatches(string $value): void
    {
        $probe = new GitFullShaProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_FULL_SHA, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'],
            ['bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'],
            ['cccccccccccccccccccccccccccccccccccccccc'],
            ['dddddddddddddddddddddddddddddddddddddddd'],
            ['eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'],
            ['ffffffffffffffffffffffffffffffffffffffff'],
            ['0123456789abcdef0123456789abcdef01234567'],
            ['abcdefabcdefabcdefabcdefabcdefabcdefabcd'],
            ['1234567890abcdef1234567890abcdef12345678'],
            ['deadbeefdeadbeefdeadbeefdeadbeefdeadbeef'],
        ];
    }
}
