<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\GradleDependencyNotationProbe;

/**
 * @internal
 */
class GradleDependencyNotationProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GradleDependencyNotationProbe();

        $expected = 'com.google.guava:guava:33.0.0-jre';
        $text = 'Value: com.google.guava:guava:33.0.0-jre';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRADLE_DEPENDENCY_NOTATION, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GradleDependencyNotationProbe();

        $expected = 'com.google.guava:guava:33.0.0-jre';
        $text = 'First com.google.guava:guava:33.0.0-jre then com.google.guava:guava:33.0.0-jre';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRADLE_DEPENDENCY_NOTATION, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(45, $results[1]->getStart());
        $this->assertSame(78, $results[1]->getEnd());
        $this->assertSame(ProbeType::GRADLE_DEPENDENCY_NOTATION, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GradleDependencyNotationProbe();

        $text = 'Value: com.google.guava:guava';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GradleDependencyNotationProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GradleDependencyNotationProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
