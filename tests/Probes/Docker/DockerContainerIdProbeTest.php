<?php

namespace Tests\Probes\Docker;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Docker\DockerContainerIdProbe;

/**
 * @internal
 */
class DockerContainerIdProbeTest extends TestCase
{
    public function testFindsShortContainerId(): void
    {
        $probe = new DockerContainerIdProbe();

        $text = 'Use container 123456789abc for logs.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('123456789abc', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CONTAINER_ID, $results[0]->getProbeType());
    }

    public function testFindsLongContainerId(): void
    {
        $probe = new DockerContainerIdProbe();

        $id = str_repeat('a', 64);
        $text = 'Full id: ' . $id . ' failed.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals($id, $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(73, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CONTAINER_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleContainerIds(): void
    {
        $probe = new DockerContainerIdProbe();

        $shortId = str_repeat('1', 12);
        $longId = str_repeat('b', 64);

        $text = 'IDs: ' . $shortId . ' and ' . $longId . ' used.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals($shortId, $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CONTAINER_ID, $results[0]->getProbeType());

        $this->assertEquals($longId, $results[1]->getResult());
        $this->assertEquals(22, $results[1]->getStart());
        $this->assertEquals(86, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CONTAINER_ID, $results[1]->getProbeType());
    }

    public function testIgnoresIdsWithInvalidLength(): void
    {
        $probe = new DockerContainerIdProbe();

        $text = 'Too short: 123456789ab and too long: 123456789abcde.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresNonHexStrings(): void
    {
        $probe = new DockerContainerIdProbe();

        $text = 'Non-hex id: 123456789abz and another: g23456789abc.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testRespectsWordBoundaries(): void
    {
        $probe = new DockerContainerIdProbe();

        $text = 'Wrapped x123456789abcy vs standalone 123456789abc.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('123456789abc', $results[0]->getResult());
        $this->assertEquals(37, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CONTAINER_ID, $results[0]->getProbeType());
    }

    public function testDoesNotMatchUppercaseHex(): void
    {
        $probe = new DockerContainerIdProbe();

        $text = 'Uppercase ABCDEF123456 should not be treated as container id.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testMatchesIdAdjacentToPunctuation(): void
    {
        $probe = new DockerContainerIdProbe();

        $text = 'Error in [123456789abc]; restart required.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('123456789abc', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CONTAINER_ID, $results[0]->getProbeType());
    }
}
