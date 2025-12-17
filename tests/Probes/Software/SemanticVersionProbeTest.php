<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\SemanticVersionProbe;

/**
 * @internal
 */
class SemanticVersionProbeTest extends TestCase
{
    public function testExtractsBasicSemanticVersion(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'Version 1.2.3 released';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('1.2.3', $results[0]->getResult());
        $this->assertSame(8, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::SEMANTIC_VERSION, $results[0]->getProbeType());
    }

    public function testExtractsPreReleaseAndBuildMetadata(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'Deploy 2.1.5-beta.1+exp.sha.5114f85 today';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('2.1.5-beta.1+exp.sha.5114f85', $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::SEMANTIC_VERSION, $results[0]->getProbeType());
    }

    public function testExtractsMultipleVersionsInOrder(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'Library 1.0.0 depends on api 2.3.4-alpha and tool 0.0.1+build.7.';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertSame('1.0.0', $results[0]->getResult());
        $this->assertSame(8, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());

        $this->assertSame('2.3.4-alpha', $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());

        $this->assertSame('0.0.1+build.7', $results[2]->getResult());
        $this->assertSame(50, $results[2]->getStart());
        $this->assertSame(63, $results[2]->getEnd());
    }

    public function testExtractsBuildMetadataWithoutPreRelease(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'artifact version 3.4.5+build.11.e0f985a';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('3.4.5+build.11.e0f985a', $results[0]->getResult());
    }

    public function testDoesNotMatchLettersTouchingVersion(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'tag v1.2.3 should be ignored while 4.5.6 is valid';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('4.5.6', $results[0]->getResult());
    }

    public function testRejectsFourSegmentVersion(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'Sequence 1.2.3.4 and 2023.04.01 should not count.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testIgnoresInvalidSemanticVersions(): void
    {
        $probe = new SemanticVersionProbe();

        $text = 'Invalid: 01.2.3, 1.02.3, 1.2.03 and 1.2.3beta should not match.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }
}
