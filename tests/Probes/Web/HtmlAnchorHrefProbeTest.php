<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HtmlAnchorHrefProbe;

/**
 * @internal
 */
class HtmlAnchorHrefProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HtmlAnchorHrefProbe();

        $expected = '<a href="https://example.com">x</a>';
        $text = 'Value: <a href="https://example.com">x</a>';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_ANCHOR_HREF, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HtmlAnchorHrefProbe();

        $expected = '<a href="https://example.com">x</a>';
        $text = 'First <a href="https://example.com">x</a> then <a href="https://example.com">x</a>';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_ANCHOR_HREF, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(47, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTML_ANCHOR_HREF, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new HtmlAnchorHrefProbe();

        $text = 'Value: <span>no link</span>';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HtmlAnchorHrefProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HtmlAnchorHrefProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
