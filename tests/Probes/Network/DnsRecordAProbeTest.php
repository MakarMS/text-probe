<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\DnsRecordAProbe;

/**
 * @internal
 */
class DnsRecordAProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DnsRecordAProbe();

        $expected = 'example.com. 3600 IN A 192.0.2.1';
        $text = 'example.com. 3600 IN A 192.0.2.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DnsRecordAProbe();

        $expected = 'www.example.com A 203.0.113.10';
        $text = 'www.example.com A 203.0.113.10';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DnsRecordAProbe();

        $first = 'example.com. 3600 IN A 192.0.2.1';
        $second = 'www.example.com A 203.0.113.10';
        $text = 'example.com. 3600 IN A 192.0.2.1' . "\n" . 'www.example.com A 203.0.113.10';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(33, $results[1]->getStart());
        $this->assertSame(63, $results[1]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DnsRecordAProbe();

        $expected = 'example.com. 3600 IN A 192.0.2.1';
        $text = 'example.com. 3600 IN A 192.0.2.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DnsRecordAProbe();

        $expected = 'example.com. 3600 IN A 192.0.2.1';
        $text = 'example.com. 3600 IN A 192.0.2.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DnsRecordAProbe();

        $expected = 'example.com. 3600 IN A 192.0.2.1';
        $text = 'example.com. 3600 IN A 192.0.2.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DnsRecordAProbe();

        $text = 'example.com A 999.1.1.1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DnsRecordAProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DnsRecordAProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DnsRecordAProbe();

        $expected = 'example.com. 3600 IN A 192.0.2.1';
        $text = 'example.com. 3600 IN A 192.0.2.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::DNS_RECORD_A, $results[0]->getProbeType());
    }
}
