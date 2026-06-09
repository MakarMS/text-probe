<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\DnsRecordMxProbe;

/**
 * @internal
 */
class DnsRecordMxProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DnsRecordMxProbe();

        $expected = 'example.com. 3600 IN MX 10 mail.example.com.';
        $text = 'example.com. 3600 IN MX 10 mail.example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DnsRecordMxProbe();

        $expected = 'example.com MX 5 mx.example.net';
        $text = 'example.com MX 5 mx.example.net';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DnsRecordMxProbe();

        $first = 'example.com. 3600 IN MX 10 mail.example.com.';
        $second = 'example.com MX 5 mx.example.net';
        $text = 'example.com. 3600 IN MX 10 mail.example.com.' . "\n" . 'example.com MX 5 mx.example.net';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(45, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DnsRecordMxProbe();

        $expected = 'example.com. 3600 IN MX 10 mail.example.com.';
        $text = 'example.com. 3600 IN MX 10 mail.example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DnsRecordMxProbe();

        $expected = 'example.com. 3600 IN MX 10 mail.example.com.';
        $text = 'example.com. 3600 IN MX 10 mail.example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DnsRecordMxProbe();

        $expected = 'example.com. 3600 IN MX 10 mail.example.com.';
        $text = 'example.com. 3600 IN MX 10 mail.example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DnsRecordMxProbe();

        $text = 'example.com MX mail.example.com';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DnsRecordMxProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DnsRecordMxProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DnsRecordMxProbe();

        $expected = 'example.com. 3600 IN MX 10 mail.example.com.';
        $text = 'example.com. 3600 IN MX 10 mail.example.com.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_MX, $results[0]->getProbeType());
    }
}
