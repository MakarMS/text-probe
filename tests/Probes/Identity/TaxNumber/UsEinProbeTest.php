<?php

namespace Tests\Probes\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\TaxNumber\UsEinProbe;

/**
 * @internal
 */
class UsEinProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UsEinProbe();

        $expected = '12-3456789';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen($prefix), $results[0]->getStart());
        $this->assertSame(strlen($prefix) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UsEinProbe();

        $expected = '98-7654321';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen($prefix), $results[0]->getStart());
        $this->assertSame(strlen($prefix) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UsEinProbe();

        $expectedFirst = '12-3456789';
        $expectedSecond = '98-7654321';
        $text = 'First
' . $expectedFirst . '
then
' . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $firstStart = strpos($text, $expectedFirst);
        $firstEnd = $firstStart + strlen($expectedFirst);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());

        $secondStart = strpos($text, $expectedSecond, $firstEnd);
        $secondEnd = $secondStart + strlen($expectedSecond);
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UsEinProbe();

        $expected = '12-3456789';
        $text = $expected . '
Tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UsEinProbe();

        $expected = '12-3456789';
        $prefix = 'Head
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen($prefix), $results[0]->getStart());
        $this->assertSame(strlen($prefix) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UsEinProbe();

        $expected = '12-3456789';
        $text = 'Check
' . $expected . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen('Check
'), $results[0]->getStart());
        $this->assertSame(strlen('Check
') + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new UsEinProbe();

        $expected = '12-3456789';
        $text = $expected . '
AND
' . $expected;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = 0;
        $firstEnd = strlen($expected);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());

        $secondStart = strpos($text, $expected, $firstEnd);
        $secondEnd = $secondStart + strlen($expected);
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new UsEinProbe();

        $expected = '98-7654321';
        $text = 'Prefix
' . $expected . '
Suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen('Prefix
'), $results[0]->getStart());
        $this->assertSame(strlen('Prefix
') + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new UsEinProbe();

        $expectedFirst = '12-3456789';
        $expectedSecond = '98-7654321';
        $text = 'First:
' . $expectedFirst . '
And:
' . $expectedSecond . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = strpos($text, $expectedFirst);
        $firstEnd = $firstStart + strlen($expectedFirst);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[0]->getProbeType());

        $secondStart = strpos($text, $expectedSecond, $firstEnd);
        $secondEnd = $secondStart + strlen($expectedSecond);
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
        $this->assertSame(ProbeType::US_EIN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new UsEinProbe();

        $text = 'Invalid
123456789
Tail';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
