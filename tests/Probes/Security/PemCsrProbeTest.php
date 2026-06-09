<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PemCsrProbe;

/**
 * @internal
 */
class PemCsrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PemCsrProbe();

        $expected = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(81, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PemCsrProbe();

        $expected = '-----BEGIN CERTIFICATE REQUEST-----
ABCDEF123456
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
ABCDEF123456
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(82, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PemCsrProbe();

        $first = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $second = '-----BEGIN CERTIFICATE REQUEST-----
ABCDEF123456
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----' . "\n" . '-----BEGIN CERTIFICATE REQUEST-----
ABCDEF123456
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(81, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(82, $results[1]->getStart());
        $this->assertSame(164, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PemCsrProbe();

        $expected = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(81, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PemCsrProbe();

        $expected = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(81, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PemCsrProbe();

        $expected = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(81, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new PemCsrProbe();

        $text = '-----BEGIN CERTIFICATE-----ABC-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new PemCsrProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new PemCsrProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new PemCsrProbe();

        $expected = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $text = '-----BEGIN CERTIFICATE REQUEST-----
MIIBexample
-----END CERTIFICATE REQUEST-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(81, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CSR, $results[0]->getProbeType());
    }
}
