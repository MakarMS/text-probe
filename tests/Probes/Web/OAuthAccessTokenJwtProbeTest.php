<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\OAuthAccessTokenJwtProbe;

/**
 * @internal
 */
class OAuthAccessTokenJwtProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'header.payload.signature';
        $text = 'Value: header.payload.signature';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'a.b.c';
        $text = 'Value: a.b.c';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expectedFirst = 'header.payload.signature';
        $expectedSecond = 'a.b.c';
        $text = 'First header.payload.signature then a.b.c';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(36, $results[1]->getStart());
        $this->assertSame(41, $results[1]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'header.payload.signature';
        $text = 'header.payload.signature tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'header.payload.signature';
        $text = 'head header.payload.signature';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'header.payload.signature';
        $text = 'Check header.payload.signature, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expectedFirst = 'header.payload.signature';
        $expectedSecond = 'header.payload.signature';
        $text = 'header.payload.signature and header.payload.signature';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(53, $results[1]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'a.b.c';
        $text = 'Prefix a.b.c suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expectedFirst = 'header.payload.signature';
        $expectedSecond = 'a.b.c';
        $text = 'header.payload.signature, a.b.c';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new OAuthAccessTokenJwtProbe();

        $expected = 'header.payload.signature';
        $text = 'Value: header.payload.signature';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::OAUTH_ACCESS_TOKEN_JWT, $results[0]->getProbeType());
    }
}
