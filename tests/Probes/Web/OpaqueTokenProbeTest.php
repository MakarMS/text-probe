<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\OpaqueTokenProbe;

/**
 * @internal
 */
class OpaqueTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'Value: ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'token_token_token_12345';
        $text = 'Value: token_token_token_12345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OpaqueTokenProbe();

        $expectedFirst = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $expectedSecond = 'token_token_token_12345';
        $text = 'First ABCDEFGHIJKLMNOPQRSTUVWXYZ1234 then token_token_token_12345';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(65, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'head ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'Check ABCDEFGHIJKLMNOPQRSTUVWXYZ1234, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new OpaqueTokenProbe();

        $expectedFirst = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $expectedSecond = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234 and ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(35, $results[1]->getStart());
        $this->assertSame(65, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'token_token_token_12345';
        $text = 'Prefix token_token_token_12345 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new OpaqueTokenProbe();

        $expectedFirst = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $expectedSecond = 'token_token_token_12345';
        $text = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234, token_token_token_12345';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(55, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new OpaqueTokenProbe();

        $expected = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $text = 'Value: ABCDEFGHIJKLMNOPQRSTUVWXYZ1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPAQUE_TOKEN, $results[0]->getProbeType());
    }
}
