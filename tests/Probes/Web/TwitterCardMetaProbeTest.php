<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\TwitterCardMetaProbe;

/**
 * @internal
 */
class TwitterCardMetaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TwitterCardMetaProbe();

        $expected = '<meta name="twitter:card" content="summary">';
        $text = '<meta name="twitter:card" content="summary">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new TwitterCardMetaProbe();

        $expected = '<meta content="@user" name="twitter:site">';
        $text = '<meta content="@user" name="twitter:site">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TwitterCardMetaProbe();

        $first = '<meta name="twitter:card" content="summary">';
        $second = '<meta content="@user" name="twitter:site">';
        $text = '<meta name="twitter:card" content="summary">' . "\n" . '<meta content="@user" name="twitter:site">';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(45, $results[1]->getStart());
        $this->assertSame(87, $results[1]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new TwitterCardMetaProbe();

        $expected = '<meta name="twitter:card" content="summary">';
        $text = '<meta name="twitter:card" content="summary">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new TwitterCardMetaProbe();

        $expected = '<meta name="twitter:card" content="summary">';
        $text = '<meta name="twitter:card" content="summary">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new TwitterCardMetaProbe();

        $expected = '<meta name="twitter:card" content="summary">';
        $text = '<meta name="twitter:card" content="summary">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new TwitterCardMetaProbe();

        $text = '<meta name="og:title" content="Title">';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TwitterCardMetaProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TwitterCardMetaProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new TwitterCardMetaProbe();

        $expected = '<meta name="twitter:card" content="summary">';
        $text = '<meta name="twitter:card" content="summary">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWITTER_CARD_META, $results[0]->getProbeType());
    }
}
