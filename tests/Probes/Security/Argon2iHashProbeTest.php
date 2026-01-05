<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\Argon2iHashProbe;

/**
 * @internal
 */
class Argon2iHashProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'Value: $argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $text = 'Value: $argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Argon2iHashProbe();

        $expectedFirst = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $expectedSecond = '$argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $text = 'First $argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA== then $argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(59, $results[1]->getStart());
        $this->assertSame(105, $results[1]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA== tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'head $argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(52, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'Check $argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new Argon2iHashProbe();

        $expectedFirst = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $expectedSecond = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA== and $argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(52, $results[1]->getStart());
        $this->assertSame(99, $results[1]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $text = 'Prefix $argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA== suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new Argon2iHashProbe();

        $expectedFirst = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $expectedSecond = '$argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $text = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==, $argon2i$v=19$m=1024,t=1,p=2$QUJDRA==$QUJDRA==';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(49, $results[1]->getStart());
        $this->assertSame(95, $results[1]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new Argon2iHashProbe();

        $expected = '$argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'Value: $argon2i$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::ARGON2I_HASH, $results[0]->getProbeType());
    }
}
