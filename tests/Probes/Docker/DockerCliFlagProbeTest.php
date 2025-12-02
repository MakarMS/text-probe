<?php

namespace Tests\Probes\Docker;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Docker\DockerCliFlagProbe;

/**
 * @internal
 */
class DockerCliFlagProbeTest extends TestCase
{
    public function testParsesShortFlagWithArgument(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Run with -p 8080:80 mapping.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('-p 8080:80', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesVolumeShortFlag(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Mount using -v src:/app option.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('-v src:/app', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesEnvironmentFlagLongSpace(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Set var with --env FOO=bar in container.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--env FOO=bar', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesEnvironmentFlagLongEquals(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Another form: --env=FOO=bar works.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--env=FOO=bar', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesNameFlagWithSpace(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Named using --name api option.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--name api', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesNameFlagWithEquals(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Also supports --name=backend.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--name=backend', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesResourceFlag(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Limit CPU via --cpus 2.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--cpus 2', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesStandaloneLongFlag(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Run detached using --rm.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--rm', $results[0]->getResult());
        $this->assertEquals(19, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesStandaloneShortFlag(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Keeping container alive with -d flag.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('-d', $results[0]->getResult());
        $this->assertEquals(29, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }

    public function testParsesMultipleFlags(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'docker run -p 80:80 -v ./src:/app --name api --env KEY=VAL';
        $results = $probe->probe($text);

        $this->assertCount(4, $results);

        $this->assertEquals('-p 80:80', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());

        $this->assertEquals('-v ./src:/app', $results[1]->getResult());
        $this->assertEquals(20, $results[1]->getStart());
        $this->assertEquals(33, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[1]->getProbeType());

        $this->assertEquals('--name api', $results[2]->getResult());
        $this->assertEquals(34, $results[2]->getStart());
        $this->assertEquals(44, $results[2]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[2]->getProbeType());

        $this->assertEquals('--env KEY=VAL', $results[3]->getResult());
        $this->assertEquals(45, $results[3]->getStart());
        $this->assertEquals(58, $results[3]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[3]->getProbeType());
    }

    public function testIgnoresTextWithoutFlags(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'This line has no docker flags at all.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testMatchesFlagsAdjacentToPunctuation(): void
    {
        $probe = new DockerCliFlagProbe();

        $text = 'Error: unknown option --rm, try again.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('--rm', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKER_CLI_FLAG, $results[0]->getProbeType());
    }
}
