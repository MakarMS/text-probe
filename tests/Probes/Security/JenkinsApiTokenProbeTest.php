<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\JenkinsApiTokenProbe;

/**
 * @internal
 */
class JenkinsApiTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new JenkinsApiTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Value: 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::JENKINS_API_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new JenkinsApiTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'First 0123456789abcdef0123456789abcdef then 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::JENKINS_API_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::JENKINS_API_TOKEN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new JenkinsApiTokenProbe();

        $text = 'Value: 0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new JenkinsApiTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new JenkinsApiTokenProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
