<?php

namespace Tests\Probes\Docker;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Docker\DockerLabelProbe;

/**
 * @internal
 */
class DockerLabelProbeTest extends TestCase
{
    public function testFindsSingleLabel(): void
    {
        $probe = new DockerLabelProbe();

        $text = 'LABEL version="1.0"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('version="1.0"', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[0]->getProbeType());
    }

    public function testFindsMultipleLabelsInOneInstruction(): void
    {
        $probe = new DockerLabelProbe();

        $text = 'LABEL version="1.0" description="Test" vendor=acme';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('version="1.0"', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[0]->getProbeType());

        $this->assertEquals('description="Test"', $results[1]->getResult());
        $this->assertEquals(20, $results[1]->getStart());
        $this->assertEquals(38, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[1]->getProbeType());

        $this->assertEquals('vendor=acme', $results[2]->getResult());
        $this->assertEquals(39, $results[2]->getStart());
        $this->assertEquals(50, $results[2]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[2]->getProbeType());
    }

    public function testFindsLabelsWithUnquotedValues(): void
    {
        $probe = new DockerLabelProbe();

        $text = 'LABEL build=2024';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('build=2024', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[0]->getProbeType());
    }

    public function testFindsLabelsAcrossMultilineInstruction(): void
    {
        $probe = new DockerLabelProbe();

        $text = "LABEL version=\"1.0\" \\\n      release=2024 \\\n      vendor=acme";
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('version="1.0"', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[0]->getProbeType());

        $this->assertEquals('release=2024', $results[1]->getResult());
        $this->assertEquals(28, $results[1]->getStart());
        $this->assertEquals(40, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[1]->getProbeType());

        $this->assertEquals('vendor=acme', $results[2]->getResult());
        $this->assertEquals(49, $results[2]->getStart());
        $this->assertEquals(60, $results[2]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[2]->getProbeType());
    }

    public function testIgnoresTextWithoutLabels(): void
    {
        $probe = new DockerLabelProbe();

        $text = 'This file contains no labels.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testMatchesLabelNextToPunctuation(): void
    {
        $probe = new DockerLabelProbe();

        $text = 'LABEL (version="1.0"), ensure consistency.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('version="1.0"', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_LABEL, $results[0]->getProbeType());
    }
}
