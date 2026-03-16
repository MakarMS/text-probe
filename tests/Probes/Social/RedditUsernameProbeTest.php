<?php

namespace Tests\Probes\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Social\RedditUsernameProbe;

/**
 * @internal
 */
class RedditUsernameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new RedditUsernameProbe();

        $expected = 'u/reddit_user';
        $text = 'Value: u/reddit_user';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::REDDIT_USERNAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new RedditUsernameProbe();

        $expected = 'u/reddit_user';
        $text = 'First u/reddit_user then u/reddit_user';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::REDDIT_USERNAME, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(38, $results[1]->getEnd());
        $this->assertSame(ProbeType::REDDIT_USERNAME, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new RedditUsernameProbe();

        $text = 'Value: reddit user';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new RedditUsernameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new RedditUsernameProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
