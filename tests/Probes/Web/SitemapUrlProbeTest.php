<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\SitemapUrlProbe;

/**
 * @internal
 */
class SitemapUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SitemapUrlProbe();

        $expected = 'https://example.com/sitemap.xml';
        $text = 'https://example.com/sitemap.xml';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SitemapUrlProbe();

        $expected = 'https://example.com/sitemap-news.xml';
        $text = 'https://example.com/sitemap-news.xml';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SitemapUrlProbe();

        $first = 'https://example.com/sitemap.xml';
        $second = 'https://example.com/sitemap-news.xml';
        $text = 'https://example.com/sitemap.xml' . "\n" . 'https://example.com/sitemap-news.xml';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(68, $results[1]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SitemapUrlProbe();

        $expected = 'https://example.com/sitemap.xml';
        $text = 'https://example.com/sitemap.xml';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SitemapUrlProbe();

        $expected = 'https://example.com/sitemap.xml';
        $text = 'https://example.com/sitemap.xml';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SitemapUrlProbe();

        $expected = 'https://example.com/sitemap.xml';
        $text = 'https://example.com/sitemap.xml';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new SitemapUrlProbe();

        $text = 'https://example.com/robots.txt';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SitemapUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SitemapUrlProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new SitemapUrlProbe();

        $expected = 'https://example.com/sitemap.xml';
        $text = 'https://example.com/sitemap.xml';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::SITEMAP_URL, $results[0]->getProbeType());
    }
}
