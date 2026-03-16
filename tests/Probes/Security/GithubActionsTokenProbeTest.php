<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GithubActionsTokenProbe;

/**
 * @internal
 */
class GithubActionsTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GithubActionsTokenProbe();

        $expected = 'ghs_1234567890123456789012345';
        $text = 'Value: ghs_1234567890123456789012345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ACTIONS_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GithubActionsTokenProbe();

        $expected = 'ghs_1234567890123456789012345';
        $text = 'First ghs_1234567890123456789012345 then ghs_1234567890123456789012345';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ACTIONS_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(70, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ACTIONS_TOKEN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GithubActionsTokenProbe();

        $text = 'Value: ghp_12345';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GithubActionsTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GithubActionsTokenProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
