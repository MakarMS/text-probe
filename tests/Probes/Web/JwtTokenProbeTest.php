<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\JwtTokenProbe;

/**
 * @internal
 */
class JwtTokenProbeTest extends TestCase
{
    public function testFindsSingleJwtToken(): void
    {
        $probe = new JwtTokenProbe();

        $text = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiamRvZSIsImFkbWluIjp0cnVlfQ.dummysignature123 provided';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiamRvZSIsImFkbWluIjp0cnVlfQ.dummysignature123', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(100, $results[0]->getEnd());
        $this->assertEquals(ProbeType::JWT_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleJwtTokens(): void
    {
        $probe = new JwtTokenProbe();

        $first = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.sgnc2lnYXR1cmUx';
        $second = 'ZXhhbXBsZS5wYXlsb2Fk.c2lnbmF0dXJl.c2Vjb25k';

        $text = "Tokens: $first and $second are present.";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(64, $results[0]->getEnd());
        $this->assertEquals(ProbeType::JWT_TOKEN, $results[0]->getProbeType());

        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(69, $results[1]->getStart());
        $this->assertEquals(111, $results[1]->getEnd());
        $this->assertEquals(ProbeType::JWT_TOKEN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidTokens(): void
    {
        $probe = new JwtTokenProbe();

        $text = 'Invalid formats: abc.def, ab@c.def, and a.b.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testDoesNotMatchWhenSegmentsAreBroken(): void
    {
        $probe = new JwtTokenProbe();

        $embedded = 'eyJhbGciOiJIUzI1NiJ9..sgnc2lnYXR1cmUxZ';

        $text = "Prefix {$embedded} suffix";
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testSupportsPunctuation(): void
    {
        $probe = new JwtTokenProbe();

        $token = 'ZXk.YWJj.YWJj';
        $text = "Here is $token.";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals($token, $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::JWT_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new JwtTokenProbe();

        $token = 'ZXk.YWJj.YWJj';
        $text = "{$token} tail";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame(0, $results[0]->getStart());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new JwtTokenProbe();

        $token = 'ZXk.YWJj.YWJj';
        $text = "head {$token}";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame(mb_strlen('head '), $results[0]->getStart());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new JwtTokenProbe();

        $token = 'ZXk.YWJj.YWJj';
        $text = "{$token} and {$token}";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new JwtTokenProbe();

        $token = 'ZXk.YWJj.YWJj';
        $text = "Value: {$token}";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame(ProbeType::JWT_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new JwtTokenProbe();

        $token = 'ZXk.YWJj.YWJj';
        $text = "Prefix {$token} suffix";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
    }
}
