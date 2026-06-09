<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\UrlWithCredentialsProbe;

/**
 * @internal
 */
class UrlWithCredentialsProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $expected = 'https://user:pass@example.com/path';
        $text = 'https://user:pass@example.com/path';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $expected = 'postgres://dbuser:secret@localhost:5432/app';
        $text = 'postgres://dbuser:secret@localhost:5432/app';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $first = 'https://user:pass@example.com/path';
        $second = 'postgres://dbuser:secret@localhost:5432/app';
        $text = 'https://user:pass@example.com/path' . "\n" . 'postgres://dbuser:secret@localhost:5432/app';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(35, $results[1]->getStart());
        $this->assertSame(78, $results[1]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $expected = 'https://user:pass@example.com/path';
        $text = 'https://user:pass@example.com/path';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $expected = 'https://user:pass@example.com/path';
        $text = 'https://user:pass@example.com/path';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $expected = 'https://user:pass@example.com/path';
        $text = 'https://user:pass@example.com/path';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $text = 'https://example.com/path';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new UrlWithCredentialsProbe();

        $expected = 'https://user:pass@example.com/path';
        $text = 'https://user:pass@example.com/path';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::URL_WITH_CREDENTIALS, $results[0]->getProbeType());
    }
}
