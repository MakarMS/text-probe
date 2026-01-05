<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CsrfTokenUuidProbe;

/**
 * @internal
 */
class CsrfTokenUuidProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Value: 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = 'ffffffff-ffff-8fff-bfff-ffffffffffff';
        $text = 'Value: ffffffff-ffff-8fff-bfff-ffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expectedFirst = '123e4567-e89b-12d3-a456-426614174000';
        $expectedSecond = 'ffffffff-ffff-8fff-bfff-ffffffffffff';
        $text = 'First 123e4567-e89b-12d3-a456-426614174000 then ffffffff-ffff-8fff-bfff-ffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(48, $results[1]->getStart());
        $this->assertSame(84, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = '123e4567-e89b-12d3-a456-426614174000 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'head 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Check 123e4567-e89b-12d3-a456-426614174000, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expectedFirst = '123e4567-e89b-12d3-a456-426614174000';
        $expectedSecond = '123e4567-e89b-12d3-a456-426614174000';
        $text = '123e4567-e89b-12d3-a456-426614174000 and 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(77, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = 'ffffffff-ffff-8fff-bfff-ffffffffffff';
        $text = 'Prefix ffffffff-ffff-8fff-bfff-ffffffffffff suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expectedFirst = '123e4567-e89b-12d3-a456-426614174000';
        $expectedSecond = 'ffffffff-ffff-8fff-bfff-ffffffffffff';
        $text = '123e4567-e89b-12d3-a456-426614174000, ffffffff-ffff-8fff-bfff-ffffffffffff';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(74, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new CsrfTokenUuidProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Value: 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_UUID, $results[0]->getProbeType());
    }
}
