<?php

namespace Tests\Probes\Finance\Swift;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Swift\UetrProbe;

/**
 * @internal
 */
class UetrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UetrProbe();

        $expected = '550e8400-e29b-41d4-a716-446655440000';
        $text = 'Value: 550e8400-e29b-41d4-a716-446655440000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UetrProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Value: 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UetrProbe();

        $expectedFirst = '550e8400-e29b-41d4-a716-446655440000';
        $expectedSecond = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'First 550e8400-e29b-41d4-a716-446655440000 then 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(48, $results[1]->getStart());
        $this->assertSame(84, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UetrProbe();

        $expected = '550e8400-e29b-41d4-a716-446655440000';
        $text = '550e8400-e29b-41d4-a716-446655440000 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UetrProbe();

        $expected = '550e8400-e29b-41d4-a716-446655440000';
        $text = 'head 550e8400-e29b-41d4-a716-446655440000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UetrProbe();

        $expected = '550e8400-e29b-41d4-a716-446655440000';
        $text = 'Check 550e8400-e29b-41d4-a716-446655440000, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new UetrProbe();

        $expectedFirst = '550e8400-e29b-41d4-a716-446655440000';
        $expectedSecond = '550e8400-e29b-41d4-a716-446655440000';
        $text = '550e8400-e29b-41d4-a716-446655440000 and 550e8400-e29b-41d4-a716-446655440000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(77, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new UetrProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Prefix 123e4567-e89b-12d3-a456-426614174000 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new UetrProbe();

        $expectedFirst = '550e8400-e29b-41d4-a716-446655440000';
        $expectedSecond = '123e4567-e89b-12d3-a456-426614174000';
        $text = '550e8400-e29b-41d4-a716-446655440000, 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(74, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new UetrProbe();

        $expected = '550e8400-e29b-41d4-a716-446655440000';
        $text = 'Value: 550e8400-e29b-41d4-a716-446655440000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_UETR, $results[0]->getProbeType());
    }
}
