<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PrivateKeyProbe;

/**
 * @internal
 */
class PrivateKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PrivateKeyProbe();

        $expected = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $text = 'Value: -----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(69, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PrivateKeyProbe();

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
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PrivateKeyProbe();

        $expectedFirst = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $text = 'First -----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY----- then -----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(68, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(74, $results[1]->getStart());
        $this->assertSame(152, $results[1]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PrivateKeyProbe();

        $expected = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $text = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY----- tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(62, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PrivateKeyProbe();

        $expected = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $text = 'head -----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PrivateKeyProbe();

        $expected = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $text = 'Check -----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(68, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PrivateKeyProbe();

        $expectedFirst = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $text = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY----- and -----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(62, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(67, $results[1]->getStart());
        $this->assertSame(129, $results[1]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PrivateKeyProbe();

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
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PrivateKeyProbe();

        $expectedFirst = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $expectedSecond = '-----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $text = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----, -----BEGIN OPENSSH PRIVATE KEY-----
YWJjZA==
-----END OPENSSH PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(62, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(64, $results[1]->getStart());
        $this->assertSame(142, $results[1]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PrivateKeyProbe();

        $expected = '-----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $text = 'Value: -----BEGIN PRIVATE KEY-----
QUJDRA==
-----END PRIVATE KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(69, $results[0]->getEnd());
        $this->assertSame(ProbeType::PRIVATE_KEY, $results[0]->getProbeType());
    }
}
