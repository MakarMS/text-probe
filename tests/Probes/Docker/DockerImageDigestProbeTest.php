<?php

namespace Tests\Probes\Docker;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Docker\DockerImageDigestProbe;

/**
 * @internal
 */
class DockerImageDigestProbeTest extends TestCase
{
    public function testFindsPlainDigest(): void
    {
        $probe = new DockerImageDigestProbe();

        $digest = 'sha256:' . str_repeat('a', 64);
        $text = "Image digest: $digest used.";

        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals($digest, $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(85, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE_DIGEST, $results[0]->getProbeType());
    }

    public function testFindsDigestWithImagePrefix(): void
    {
        $probe = new DockerImageDigestProbe();

        $digest = 'sha256:' . str_repeat('b', 64);
        $text = "ubuntu@$digest pulled";

        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals($digest, $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(78, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE_DIGEST, $results[0]->getProbeType());
    }

    public function testFindsMultipleDigests(): void
    {
        $probe = new DockerImageDigestProbe();

        $d1 = 'sha256:' . str_repeat('c', 64);
        $d2 = 'sha256:' . str_repeat('d', 64);

        $text = "First: $d1 then: alpine@$d2 ok.";

        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals($d1, $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(78, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE_DIGEST, $results[0]->getProbeType());

        $this->assertEquals($d2, $results[1]->getResult());
        $this->assertEquals(92, $results[1]->getStart());
        $this->assertEquals(163, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE_DIGEST, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidLength(): void
    {
        $probe = new DockerImageDigestProbe();

        $text = 'Bad digest: sha256:' . str_repeat('a', 10);
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresUppercaseDigest(): void
    {
        $probe = new DockerImageDigestProbe();

        $text = 'Invalid: sha256:' . strtoupper(str_repeat('a', 64));
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testIgnoresNonHexCharacters(): void
    {
        $probe = new DockerImageDigestProbe();

        $text = 'Bad: sha256:' . str_repeat('z', 64);
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testMatchesDigestAdjacentToPunctuation(): void
    {
        $probe = new DockerImageDigestProbe();

        $digest = 'sha256:' . str_repeat('e', 64);
        $text = "Error: [$digest], check logs.";

        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals($digest, $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(79, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE_DIGEST, $results[0]->getProbeType());
    }

    public function testIgnoresTextWithoutDigest(): void
    {
        $probe = new DockerImageDigestProbe();

        $text = 'Nothing here.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
