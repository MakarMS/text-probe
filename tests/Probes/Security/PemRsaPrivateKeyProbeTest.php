<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PemRsaPrivateKeyProbe;

/**
 * @internal
 */
class PemRsaPrivateKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $text = 'Value: -----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(77, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $text = 'Value: -----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(77, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expectedFirst = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $text = 'First -----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY----- then -----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(76, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(82, $results[1]->getStart());
        $this->assertSame(152, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $text = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY----- tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $text = 'head -----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(75, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $text = 'Check -----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(76, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expectedFirst = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $text = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY----- and -----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(75, $results[1]->getStart());
        $this->assertSame(145, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $text = 'Prefix -----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY----- suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(77, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expectedFirst = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $text = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----, -----BEGIN RSA PRIVATE KEY-----
YWJjZA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(70, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(72, $results[1]->getStart());
        $this->assertSame(142, $results[1]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PemRsaPrivateKeyProbe();

        $expected = '-----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $text = 'Value: -----BEGIN RSA PRIVATE KEY-----
QUJDRA==
-----END RSA PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(77, $results[0]->getEnd());
        $this->assertSame(ProbeType::PEM_RSA_PRIVATE_KEY, $results[0]->getProbeType());
    }
}
