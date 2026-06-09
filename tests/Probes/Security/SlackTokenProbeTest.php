<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SlackTokenProbe;

/**
 * @internal
 */
class SlackTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SlackTokenProbe();

        $expected = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $text = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SlackTokenProbe();

        $expected = 'xapp-1-A1234567890-1234567890123-abcdef1234567890abcdef1234567890';
        $text = 'xapp-1-A1234567890-1234567890123-abcdef1234567890abcdef1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(65, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SlackTokenProbe();

        $first = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $second = 'xapp-1-A1234567890-1234567890123-abcdef1234567890abcdef1234567890';
        $text = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv' . "\n" . 'xapp-1-A1234567890-1234567890123-abcdef1234567890abcdef1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(54, $results[1]->getStart());
        $this->assertSame(119, $results[1]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SlackTokenProbe();

        $expected = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $text = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SlackTokenProbe();

        $expected = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $text = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SlackTokenProbe();

        $expected = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $text = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new SlackTokenProbe();

        $text = 'xoxb-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SlackTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SlackTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new SlackTokenProbe();

        $expected = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $text = 'xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::SLACK_TOKEN, $results[0]->getProbeType());
    }
}
