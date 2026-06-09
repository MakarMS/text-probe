<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\OpenGraphMetaProbe;

/**
 * @internal
 */
class OpenGraphMetaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OpenGraphMetaProbe();

        $expected = '<meta property="og:title" content="Title">';
        $text = '<meta property="og:title" content="Title">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OpenGraphMetaProbe();

        $expected = '<meta content="Site" property="og:site_name">';
        $text = '<meta content="Site" property="og:site_name">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(45, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OpenGraphMetaProbe();

        $first = '<meta property="og:title" content="Title">';
        $second = '<meta content="Site" property="og:site_name">';
        $text = '<meta property="og:title" content="Title">' . "\n" . '<meta content="Site" property="og:site_name">';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(43, $results[1]->getStart());
        $this->assertSame(88, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OpenGraphMetaProbe();

        $expected = '<meta property="og:title" content="Title">';
        $text = '<meta property="og:title" content="Title">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OpenGraphMetaProbe();

        $expected = '<meta property="og:title" content="Title">';
        $text = '<meta property="og:title" content="Title">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OpenGraphMetaProbe();

        $expected = '<meta property="og:title" content="Title">';
        $text = '<meta property="og:title" content="Title">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new OpenGraphMetaProbe();

        $text = '<meta name="description" content="Text">';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new OpenGraphMetaProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new OpenGraphMetaProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new OpenGraphMetaProbe();

        $expected = '<meta property="og:title" content="Title">';
        $text = '<meta property="og:title" content="Title">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPEN_GRAPH_META, $results[0]->getProbeType());
    }
}
