<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CsrfTokenProbe;

/**
 * @internal
 */
class CsrfTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Value: 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Value: 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CsrfTokenProbe();

        $expectedFirst = '0123456789abcdef0123456789abcdef';
        $expectedSecond = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'First 0123456789abcdef0123456789abcdef then 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'head 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Check 0123456789abcdef0123456789abcdef, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new CsrfTokenProbe();

        $expectedFirst = '0123456789abcdef0123456789abcdef';
        $expectedSecond = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef and 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(69, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '123e4567-e89b-12d3-a456-426614174000';
        $text = 'Prefix 123e4567-e89b-12d3-a456-426614174000 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new CsrfTokenProbe();

        $expectedFirst = '0123456789abcdef0123456789abcdef';
        $expectedSecond = '123e4567-e89b-12d3-a456-426614174000';
        $text = '0123456789abcdef0123456789abcdef, 123e4567-e89b-12d3-a456-426614174000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(34, $results[1]->getStart());
        $this->assertSame(70, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new CsrfTokenProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Value: 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN, $results[0]->getProbeType());
    }
}
