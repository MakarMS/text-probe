<?php

namespace Tests\Probes\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Social\YoutubeChannelUrlProbe;

/**
 * @internal
 */
class YoutubeChannelUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new YoutubeChannelUrlProbe();

        $expected = 'https://www.youtube.com/@mychannel';
        $text = 'Value: https://www.youtube.com/@mychannel';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::YOUTUBE_CHANNEL_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new YoutubeChannelUrlProbe();

        $expected = 'https://www.youtube.com/@mychannel';
        $text = 'First https://www.youtube.com/@mychannel then https://www.youtube.com/@mychannel';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::YOUTUBE_CHANNEL_URL, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(46, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::YOUTUBE_CHANNEL_URL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new YoutubeChannelUrlProbe();

        $text = 'Value: https://youtube.com/watch?v=1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new YoutubeChannelUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new YoutubeChannelUrlProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
