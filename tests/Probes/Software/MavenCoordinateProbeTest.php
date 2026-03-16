<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\MavenCoordinateProbe;

/**
 * @internal
 */
class MavenCoordinateProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MavenCoordinateProbe();

        $expected = 'org.slf4j:slf4j-api:2.0.7';
        $text = 'Value: org.slf4j:slf4j-api:2.0.7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::MAVEN_COORDINATE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MavenCoordinateProbe();

        $expected = 'org.slf4j:slf4j-api:2.0.7';
        $text = 'First org.slf4j:slf4j-api:2.0.7 then org.slf4j:slf4j-api:2.0.7';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::MAVEN_COORDINATE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(62, $results[1]->getEnd());
        $this->assertSame(ProbeType::MAVEN_COORDINATE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new MavenCoordinateProbe();

        $text = 'Value: org.slf4j:slf4j-api';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new MavenCoordinateProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new MavenCoordinateProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
