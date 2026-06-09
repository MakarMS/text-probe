<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\DnsRecordCnameProbe;

/**
 * @internal
 */
class DnsRecordCnameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DnsRecordCnameProbe();

        $expected = 'www.example.com. 3600 IN CNAME example.com.';
        $text = 'www.example.com. 3600 IN CNAME example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DnsRecordCnameProbe();

        $expected = 'cdn.example.com CNAME edge.example.net';
        $text = 'cdn.example.com CNAME edge.example.net';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DnsRecordCnameProbe();

        $first = 'www.example.com. 3600 IN CNAME example.com.';
        $second = 'cdn.example.com CNAME edge.example.net';
        $text = 'www.example.com. 3600 IN CNAME example.com.' . "\n" . 'cdn.example.com CNAME edge.example.net';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DnsRecordCnameProbe();

        $expected = 'www.example.com. 3600 IN CNAME example.com.';
        $text = 'www.example.com. 3600 IN CNAME example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DnsRecordCnameProbe();

        $expected = 'www.example.com. 3600 IN CNAME example.com.';
        $text = 'www.example.com. 3600 IN CNAME example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DnsRecordCnameProbe();

        $expected = 'www.example.com. 3600 IN CNAME example.com.';
        $text = 'www.example.com. 3600 IN CNAME example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DnsRecordCnameProbe();

        $text = 'www.example.com CNAME';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DnsRecordCnameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DnsRecordCnameProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DnsRecordCnameProbe();

        $expected = 'www.example.com. 3600 IN CNAME example.com.';
        $text = 'www.example.com. 3600 IN CNAME example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_CNAME, $results[0]->getProbeType());
    }
}
