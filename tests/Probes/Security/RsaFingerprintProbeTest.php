<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\RsaFingerprintProbe;

/**
 * @internal
 */
class RsaFingerprintProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new RsaFingerprintProbe();

        $expected = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new RsaFingerprintProbe();

        $expected = 'SHA256:ABCDEFGHIJKLMNOPQRSTUVWXYZ_1234567890';
        $text = 'SHA256:ABCDEFGHIJKLMNOPQRSTUVWXYZ_1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new RsaFingerprintProbe();

        $first = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $second = 'SHA256:ABCDEFGHIJKLMNOPQRSTUVWXYZ_1234567890';
        $text = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890' . "\n" . 'SHA256:ABCDEFGHIJKLMNOPQRSTUVWXYZ_1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(88, $results[1]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new RsaFingerprintProbe();

        $expected = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new RsaFingerprintProbe();

        $expected = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new RsaFingerprintProbe();

        $expected = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new RsaFingerprintProbe();

        $text = 'MD5:aa:bb:cc';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new RsaFingerprintProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new RsaFingerprintProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new RsaFingerprintProbe();

        $expected = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'SHA256:abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::RSA_FINGERPRINT, $results[0]->getProbeType());
    }
}
