<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\BearerTokenProbe;

/**
 * @internal
 */
class BearerTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $text = 'Value: eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(57, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'Value: ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new BearerTokenProbe();

        $expectedFirst = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $expectedSecond = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'First eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature then ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(62, $results[1]->getStart());
        $this->assertSame(92, $results[1]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $text = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $text = 'head eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $text = 'Check eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new BearerTokenProbe();

        $expectedFirst = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $expectedSecond = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $text = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature and eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(55, $results[1]->getStart());
        $this->assertSame(105, $results[1]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'Prefix ABCDEFGHIJKLMNOPQRSTUVWXYZ1234 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new BearerTokenProbe();

        $expectedFirst = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $expectedSecond = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature, ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(52, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new BearerTokenProbe();

        $expected = 'eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $text = 'Value: eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0In0.signature';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(57, $results[0]->getEnd());
        $this->assertSame(ProbeType::BEARER_TOKEN, $results[0]->getProbeType());
    }
}
