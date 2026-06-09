<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\DnsRecordAaaaProbe;

/**
 * @internal
 */
class DnsRecordAaaaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $expected = 'example.com. 3600 IN AAAA 2001:db8::1';
        $text = 'example.com. 3600 IN AAAA 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $expected = 'www.example.com AAAA 2001:db8:0:0:0:0:0:2';
        $text = 'www.example.com AAAA 2001:db8:0:0:0:0:0:2';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $first = 'example.com. 3600 IN AAAA 2001:db8::1';
        $second = 'www.example.com AAAA 2001:db8:0:0:0:0:0:2';
        $text = 'example.com. 3600 IN AAAA 2001:db8::1' . "\n" . 'www.example.com AAAA 2001:db8:0:0:0:0:0:2';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(79, $results[1]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $expected = 'example.com. 3600 IN AAAA 2001:db8::1';
        $text = 'example.com. 3600 IN AAAA 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $expected = 'example.com. 3600 IN AAAA 2001:db8::1';
        $text = 'example.com. 3600 IN AAAA 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $expected = 'example.com. 3600 IN AAAA 2001:db8::1';
        $text = 'example.com. 3600 IN AAAA 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $text = 'example.com AAAA not-ipv6';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DnsRecordAaaaProbe();

        $expected = 'example.com. 3600 IN AAAA 2001:db8::1';
        $text = 'example.com. 3600 IN AAAA 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_AAAA, $results[0]->getProbeType());
    }
}
