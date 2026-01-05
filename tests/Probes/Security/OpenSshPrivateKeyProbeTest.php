<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\OpenSshPrivateKeyProbe;

/**
 * @internal
 */
class OpenSshPrivateKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'Value: -----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(85, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'Value: -----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(85, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expectedFirst = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'First -----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY----- then -----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(84, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(90, $results[1]->getStart());
        $this->assertSame(168, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $text = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY----- tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(78, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'head -----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(83, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'Check -----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(84, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expectedFirst = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $text = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY----- and -----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(78, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(83, $results[1]->getStart());
        $this->assertSame(161, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'Prefix -----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY----- suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(85, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expectedFirst = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $text = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----, -----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(78, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(80, $results[1]->getStart());
        $this->assertSame(158, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new OpenSshPrivateKeyProbe();

        $expected = '-----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'Value: -----BEGIN OPENSSH PRIVATE KEY-----
QUJDRA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(85, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENSSH_PRIVATE_KEY, $results[0]->getProbeType());
    }
}
