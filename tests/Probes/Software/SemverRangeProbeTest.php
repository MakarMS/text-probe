<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\SemverRangeProbe;

/**
 * @internal
 */
class SemverRangeProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('rangeProvider')]
    public function testFindsSemverRanges(string $text, string $expected): void
    {
        $probe = new SemverRangeProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(ProbeType::SEMVER_RANGE, $results[0]->getProbeType());
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function rangeProvider(): array
    {
        return [
            'composer-caret' => ['Use ^1.2.3 to stay compatible', '^1.2.3'],
            'composer-tilde' => ['Prefer ~2.1.0 in lock', '~2.1.0'],
            'composer-range' => ['Range is >=1.2.3 <2.0.0', '>=1.2.3 <2.0.0'],
            'composer-or' => ['Either ^1.2.3 || >=2.0.0 works', '^1.2.3 || >=2.0.0'],
            'composer-comma' => ['Exact >=1.2.3, <2.0.0', '>=1.2.3, <2.0.0'],
            'plain-version' => ['Version 3.4.5 released', '3.4.5'],
            'prerelease' => ['Test 1.2.3-alpha.1+build.9', '1.2.3-alpha.1+build.9'],
            'prefixed-version' => ['Using v4.5.6 today', 'v4.5.6'],
            'greater-than' => ['Policy >1.2.3 only', '>1.2.3'],
            'less-than' => ['Legacy <2.0.0', '<2.0.0'],
        ];
    }
}
