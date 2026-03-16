<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HtmlMetaRefreshUrlProbe;

/**
 * @internal
 */
class HtmlMetaRefreshUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HtmlMetaRefreshUrlProbe();

        $expected = '<meta http-equiv="refresh" content="0;url=https://example.com">';
        $text = 'Value: <meta http-equiv="refresh" content="0;url=https://example.com">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_META_REFRESH_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HtmlMetaRefreshUrlProbe();

        $expected = '<meta http-equiv="refresh" content="0;url=https://example.com">';
        $text = 'First <meta http-equiv="refresh" content="0;url=https://example.com"> then <meta http-equiv="refresh" content="0;url=https://example.com">';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(69, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_META_REFRESH_URL, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(75, $results[1]->getStart());
        $this->assertSame(138, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTML_META_REFRESH_URL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new HtmlMetaRefreshUrlProbe();

        $text = 'Value: <meta charset="utf-8">';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HtmlMetaRefreshUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HtmlMetaRefreshUrlProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
