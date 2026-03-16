<?php

namespace Tests\Probes\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Social\MastodonHandleProbe;

/**
 * @internal
 */
class MastodonHandleProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MastodonHandleProbe();

        $expected = '@alice@mastodon.social';
        $text = 'Value: @alice@mastodon.social';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::MASTODON_HANDLE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MastodonHandleProbe();

        $expected = '@alice@mastodon.social';
        $text = 'First @alice@mastodon.social then @alice@mastodon.social';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(28, $results[0]->getEnd());
        $this->assertSame(ProbeType::MASTODON_HANDLE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(34, $results[1]->getStart());
        $this->assertSame(56, $results[1]->getEnd());
        $this->assertSame(ProbeType::MASTODON_HANDLE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new MastodonHandleProbe();

        $text = 'Value: @alice-mastodon';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new MastodonHandleProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new MastodonHandleProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
