<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\TlsCertificateFingerprintSha256Probe;

/**
 * @internal
 */
class TlsCertificateFingerprintSha256ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $expected = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $expected = 'SHA256 Fingerprint=00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF';
        $text = 'SHA256 Fingerprint=00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $first = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $second = 'SHA256 Fingerprint=00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF';
        $text = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99' . "\n" . 'SHA256 Fingerprint=00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(115, $results[1]->getStart());
        $this->assertSame(229, $results[1]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $expected = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $expected = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $expected = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $text = 'SHA256 Fingerprint=AA:BB';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new TlsCertificateFingerprintSha256Probe();

        $expected = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $text = 'SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(114, $results[0]->getEnd());
        $this->assertSame(ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256, $results[0]->getProbeType());
    }
}
