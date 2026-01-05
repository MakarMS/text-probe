<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PublicKeyProbe;

/**
 * @internal
 */
class PublicKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $text = 'Value: -----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(65, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = 'Value: -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PublicKeyProbe();

        $expectedFirst = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $expectedSecond = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----, -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(58, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(60, $results[1]->getStart());
        $this->assertSame(120, $results[1]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $text = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(58, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $text = 'head -----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(63, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $text = 'Check -----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(64, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PublicKeyProbe();

        $expectedFirst = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $expectedSecond = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $text = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----, -----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(58, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(60, $results[1]->getStart());
        $this->assertSame(118, $results[1]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = 'Prefix -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PublicKeyProbe();

        $expectedFirst = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $expectedSecond = '-----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $text = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----; -----BEGIN CERTIFICATE-----YWJjZA==-----END CERTIFICATE-----';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(58, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(60, $results[1]->getStart());
        $this->assertSame(120, $results[1]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PublicKeyProbe();

        $expected = '-----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $text = 'Value: -----BEGIN PUBLIC KEY-----QUJDRA==-----END PUBLIC KEY-----';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(65, $results[0]->getEnd());
        $this->assertSame(ProbeType::PUBLIC_KEY, $results[0]->getProbeType());
    }
}
