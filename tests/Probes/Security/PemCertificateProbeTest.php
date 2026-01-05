<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PemCertificateProbe;

/**
 * @internal
 */
class PemCertificateProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $text = 'Value: -----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = 'Value: -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PemCertificateProbe();

        $expectedFirst = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $expectedSecond = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----, -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(62, $results[1]->getStart());
        $this->assertSame(122, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $text = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $text = 'head -----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(65, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $text = 'Check -----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PemCertificateProbe();

        $expectedFirst = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $expectedSecond = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $text = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----, -----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(62, $results[1]->getStart());
        $this->assertSame(122, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = 'Prefix -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PemCertificateProbe();

        $expectedFirst = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $expectedSecond = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----; -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(62, $results[1]->getStart());
        $this->assertSame(122, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PemCertificateProbe();

        $expected = '-----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $text = 'Value: -----BEGIN CERTIFICATE-----QUJDRA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_CERTIFICATE, $results[0]->getProbeType());
    }
}
