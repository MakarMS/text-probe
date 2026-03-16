<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\HelmReleaseNameProbe;

/**
 * @internal
 */
class HelmReleaseNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HelmReleaseNameProbe();

        $expected = 'my-release-1';
        $text = 'Value: my-release-1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::HELM_RELEASE_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HelmReleaseNameProbe();

        $expected = 'my-release-1';
        $text = 'my-release-1,my-release-1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::HELM_RELEASE_NAME, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::HELM_RELEASE_NAME, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new HelmReleaseNameProbe();

        $text = 'Value: MY_RELEASE';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HelmReleaseNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HelmReleaseNameProbe();

        $results = $probe->probe('NO_MATCH __ ---');

        $this->assertCount(0, $results);
    }
}
