<?php

namespace Tests\Probes\Docker;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Docker\DockerfileInstructionProbe;

/**
 * @internal
 */
class DockerfileInstructionProbeTest extends TestCase
{
    public function testFindsFromInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'FROM php:8.3-fpm-alpine';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('FROM php:8.3-fpm-alpine', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsRunInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'RUN apt-get update';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('RUN apt-get update', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsCmdInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'CMD ["php-fpm"]';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('CMD ["php-fpm"]', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsEntrypointInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'ENTRYPOINT ["sh","-c","php-fpm"]';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ENTRYPOINT ["sh","-c","php-fpm"]', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(32, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsCopyInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'COPY . /app';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('COPY . /app', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(11, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsAddInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'ADD src/ /app';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ADD src/ /app', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsWorkdirInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'WORKDIR /var/www/html';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('WORKDIR /var/www/html', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsEnvInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'ENV APP_ENV=prod';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ENV APP_ENV=prod', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsExposeInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'EXPOSE 8080';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('EXPOSE 8080', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(11, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsVolumeInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'VOLUME /data';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('VOLUME /data', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsUserInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'USER appuser';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('USER appuser', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsLabelInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'LABEL version="1.0"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('LABEL version="1.0"', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsArgInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'ARG APP_ENV';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('ARG APP_ENV', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(11, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsStopsignalInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'STOPSIGNAL SIGTERM';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('STOPSIGNAL SIGTERM', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsHealthcheckInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'HEALTHCHECK CMD curl -f http://localhost/health || exit 1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals(
            'HEALTHCHECK CMD curl -f http://localhost/health || exit 1',
            $results[0]->getResult(),
        );
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(57, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testFindsShellInstruction(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = 'SHELL ["/bin/sh", "-c"]';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('SHELL ["/bin/sh", "-c"]', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());
    }

    public function testMatchesMultipleInstructionsAndIsCaseInsensitive(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = "   from debian:12\nRUN echo 1\n  copy . /app\n";
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('from debian:12', $results[0]->getResult());
        $this->assertEquals(3, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[0]->getProbeType());

        $this->assertEquals('RUN echo 1', $results[1]->getResult());
        $this->assertEquals(18, $results[1]->getStart());
        $this->assertEquals(28, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[1]->getProbeType());

        $this->assertEquals('copy . /app', $results[2]->getResult());
        $this->assertEquals(31, $results[2]->getStart());
        $this->assertEquals(42, $results[2]->getEnd());
        $this->assertEquals(ProbeType::DOCKERFILE_INSTRUCTION, $results[2]->getProbeType());
    }

    public function testIgnoresNonInstructionLines(): void
    {
        $probe = new DockerfileInstructionProbe();

        $text = "# comment\nnot_an_instruction value\nOTHER text";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
