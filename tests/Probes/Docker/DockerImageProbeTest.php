<?php

namespace Tests\Probes\Docker;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Docker\DockerImageProbe;

class DockerImageProbeTest extends TestCase
{
    public function testFindsSimpleImage(): void
    {
        $probe = new DockerImageProbe();

        $text = 'Use nginx:1.25.1 for production.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('nginx:1.25.1', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE, $results[0]->getProbeType());
    }

    public function testDoesNotFindImageWithoutTag(): void
    {
        $probe = new DockerImageProbe();

        $text = 'Base image is python.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsNamespacedImage(): void
    {
        $probe = new DockerImageProbe();

        $text = 'Deploy ghcr.io/myorg/api:latest in cluster.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ghcr.io/myorg/api:latest', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE, $results[0]->getProbeType());
    }

    public function testFindsOnlyTaggedImages(): void
    {
        $probe = new DockerImageProbe();

        $text = 'Images: redis:latest, nginx:1.0, myapp/web.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('redis:latest', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE, $results[0]->getProbeType());

        $this->assertEquals('nginx:1.0', $results[1]->getResult());
        $this->assertEquals(22, $results[1]->getStart());
        $this->assertEquals(31, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE, $results[1]->getProbeType());
    }

    public function testFindsLowercaseImage(): void
    {
        $probe = new DockerImageProbe();

        $text = 'lowercase: myapp/api:dev';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('myapp/api:dev', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(24, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_IMAGE, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidImage(): void
    {
        $probe = new DockerImageProbe();

        $text = 'Invalid image: nginx:';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
