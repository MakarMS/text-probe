<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HtmlImgSrcProbe;

/**
 * @internal
 */
class HtmlImgSrcProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HtmlImgSrcProbe();

        $expected = '<img src="/a.png" alt="x">';
        $text = 'Value: <img src="/a.png" alt="x">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_IMG_SRC, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HtmlImgSrcProbe();

        $expected = '<img src="/a.png" alt="x">';
        $text = 'First <img src="/a.png" alt="x"> then <img src="/a.png" alt="x">';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_IMG_SRC, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(64, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTML_IMG_SRC, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new HtmlImgSrcProbe();

        $text = 'Value: <img alt="x">';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HtmlImgSrcProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HtmlImgSrcProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
