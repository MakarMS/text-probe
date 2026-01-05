<?php

namespace Tests\Probes\Identity\Passport;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\Passport\MrzTd1Probe;

/**
 * @internal
 */
class MrzTd1ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $text = 'Value:
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(99, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'Value:
DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(99, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MrzTd1Probe();

        $expectedFirst = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $expectedSecond = 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'First
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC
then
DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(98, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(104, $results[1]->getStart());
        $this->assertSame(196, $results[1]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $text = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC
Tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(92, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $text = 'Head
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(97, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $text = 'Check
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC
End.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(98, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new MrzTd1Probe();

        $expectedFirst = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $expectedSecond = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $text = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC
AND
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(92, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(97, $results[1]->getStart());
        $this->assertSame(189, $results[1]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'Prefix
DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
Suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(99, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new MrzTd1Probe();

        $expectedFirst = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $expectedSecond = 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC
.
DDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(92, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(95, $results[1]->getStart());
        $this->assertSame(187, $results[1]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new MrzTd1Probe();

        $expected = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $text = 'Value:
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB
CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(99, $results[0]->getEnd());
        $this->assertSame(ProbeType::MRZ_TD1, $results[0]->getProbeType());
    }
}
