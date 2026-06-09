<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\Sha256FingerprintProbe;

/**
 * @internal
 */
class Sha256FingerprintProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Sha256FingerprintProbe();

        $expected = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new Sha256FingerprintProbe();

        $expected = 'AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = 'AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(95, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Sha256FingerprintProbe();

        $first = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $second = 'AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef' . "\n" . 'AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(65, $results[1]->getStart());
        $this->assertSame(160, $results[1]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new Sha256FingerprintProbe();

        $expected = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new Sha256FingerprintProbe();

        $expected = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new Sha256FingerprintProbe();

        $expected = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new Sha256FingerprintProbe();

        $text = '0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new Sha256FingerprintProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new Sha256FingerprintProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new Sha256FingerprintProbe();

        $expected = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::SHA256_FINGERPRINT, $results[0]->getProbeType());
    }
}
