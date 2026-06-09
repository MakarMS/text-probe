<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\DnsRecordTxtProbe;

/**
 * @internal
 */
class DnsRecordTxtProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DnsRecordTxtProbe();

        $expected = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $text = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DnsRecordTxtProbe();

        $expected = 'example.com TXT "google-site-verification=abc123"';
        $text = 'example.com TXT "google-site-verification=abc123"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(49, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DnsRecordTxtProbe();

        $first = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $second = 'example.com TXT "google-site-verification=abc123"';
        $text = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"' . "\n" . 'example.com TXT "google-site-verification=abc123"';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(64, $results[1]->getStart());
        $this->assertSame(113, $results[1]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DnsRecordTxtProbe();

        $expected = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $text = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DnsRecordTxtProbe();

        $expected = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $text = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DnsRecordTxtProbe();

        $expected = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $text = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DnsRecordTxtProbe();

        $text = 'example.com TXT unquoted';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DnsRecordTxtProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DnsRecordTxtProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DnsRecordTxtProbe();

        $expected = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $text = 'example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_TXT, $results[0]->getProbeType());
    }
}
