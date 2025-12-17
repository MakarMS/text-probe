<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HtmlTagProbe;

/**
 * @internal
 */
class HtmlTagProbeTest extends TestCase
{
    public function testPairedTagIsCapturedWithContent(): void
    {
        $probe = new HtmlTagProbe();

        $text = 'Content <div class="box">inner</div> end.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('<div class="box">inner</div>', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(36, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HTML_TAG, $results[0]->getProbeType());
    }

    public function testSelfClosingAndImageTags(): void
    {
        $probe = new HtmlTagProbe();

        $text = 'Line break<br/>and image <img src="a.png" alt="a" /> done.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('<br/>', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HTML_TAG, $results[0]->getProbeType());

        $this->assertEquals('<img src="a.png" alt="a" />', $results[1]->getResult());
        $this->assertEquals(25, $results[1]->getStart());
        $this->assertEquals(52, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HTML_TAG, $results[1]->getProbeType());
    }

    public function testSingleTagWithoutTrailingSlash(): void
    {
        $probe = new HtmlTagProbe();

        $text = 'Meta: <meta charset="utf-8"> inside';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('<meta charset="utf-8">', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HTML_TAG, $results[0]->getProbeType());
    }

    public function testMultiplePairedTags(): void
    {
        $probe = new HtmlTagProbe();

        $text = 'List: <p>First</p> <p>Second</p> done';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('<p>First</p>', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HTML_TAG, $results[0]->getProbeType());

        $this->assertEquals('<p>Second</p>', $results[1]->getResult());
        $this->assertEquals(19, $results[1]->getStart());
        $this->assertEquals(32, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HTML_TAG, $results[1]->getProbeType());
    }

    public function testNoTagsReturnsEmpty(): void
    {
        $probe = new HtmlTagProbe();

        $text = 'Plain text without any HTML markers.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }
}
