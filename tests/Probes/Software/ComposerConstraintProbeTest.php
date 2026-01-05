<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\ComposerConstraintProbe;

/**
 * @internal
 */
class ComposerConstraintProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('constraintProvider')]
    public function testFindsComposerConstraints(string $text, string $expected): void
    {
        $probe = new ComposerConstraintProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(ProbeType::COMPOSER_CONSTRAINT, $results[0]->getProbeType());
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function constraintProvider(): array
    {
        return [
            'caret' => ['Requires ^1.2.3', '^1.2.3'],
            'tilde' => ['Compat: ~2.3.4', '~2.3.4'],
            'gte' => ['Minimum is >=1.0.0', '>=1.0.0'],
            'lte' => ['Maximum is <=2.0.0', '<=2.0.0'],
            'range' => ['Use >=1.2.3 <2.0.0', '>=1.2.3 <2.0.0'],
            'or' => ['Accept ^1.2.3 || >=2.0.0', '^1.2.3 || >=2.0.0'],
            'comma' => ['Lock to >=1.2.3, <2.0.0', '>=1.2.3, <2.0.0'],
            'version' => ['Pin 1.2.3 for now', '1.2.3'],
            'v-prefix' => ['Version v2.0.1 is ok', 'v2.0.1'],
            'prerelease' => ['Allow 1.2.3-beta.1+build.7', '1.2.3-beta.1+build.7'],
        ];
    }
}
