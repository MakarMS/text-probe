<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\CommitConventionalTypeProbe;

/**
 * @internal
 */
class CommitConventionalTypeProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CommitConventionalTypeProbe();

        $expected = 'feat(api): add endpoint';
        $text = 'Value: feat(api): add endpoint';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMMIT_CONVENTIONAL_TYPE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CommitConventionalTypeProbe();

        $expected = 'feat(api): add endpoint';
        $text = "feat(api): add endpoint\nfeat(api): add endpoint";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMMIT_CONVENTIONAL_TYPE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(24, $results[1]->getStart());
        $this->assertSame(47, $results[1]->getEnd());
        $this->assertSame(ProbeType::COMMIT_CONVENTIONAL_TYPE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new CommitConventionalTypeProbe();

        $text = 'Value: feature: add endpoint';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CommitConventionalTypeProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CommitConventionalTypeProbe();

        $results = $probe->probe('NO_MATCH __ ---');

        $this->assertCount(0, $results);
    }
}
