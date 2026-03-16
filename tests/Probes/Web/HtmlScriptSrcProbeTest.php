<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HtmlScriptSrcProbe;

/**
 * @internal
 */
class HtmlScriptSrcProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HtmlScriptSrcProbe();

        $expected = '<script src="/app.js"></script>';
        $text = 'Value: <script src="/app.js"></script>';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_SCRIPT_SRC, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HtmlScriptSrcProbe();

        $expected = '<script src="/app.js"></script>';
        $text = 'First <script src="/app.js"></script> then <script src="/app.js"></script>';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTML_SCRIPT_SRC, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(43, $results[1]->getStart());
        $this->assertSame(74, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTML_SCRIPT_SRC, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new HtmlScriptSrcProbe();

        $text = 'Value: <script>var x=1;</script>';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HtmlScriptSrcProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HtmlScriptSrcProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
