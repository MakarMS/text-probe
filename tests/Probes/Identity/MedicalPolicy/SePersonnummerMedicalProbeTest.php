<?php

namespace Tests\Probes\Identity\MedicalPolicy;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\MedicalPolicy\SePersonnummerMedicalProbe;

/**
 * @internal
 */
class SePersonnummerMedicalProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '640823-1238';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '991231+1124';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expectedFirst = '640823-1238';
        $expectedSecond = '991231+1124';
        $text = 'First
' . $expectedFirst . '
then
' . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '640823-1238';
        $text = $expected . '
Tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '640823-1238';
        $prefix = 'Head
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '640823-1238';
        $text = 'Check
' . $expected . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '640823-1238';
        $text = $expected . '
AND
' . $expected;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = 0;
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expected = '991231+1124';
        $text = 'Prefix
' . $expected . '
Suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $expectedFirst = '640823-1238';
        $expectedSecond = '991231+1124';
        $text = 'First:
' . $expectedFirst . '
And:
' . $expectedSecond . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(24, $results[1]->getStart());
        $this->assertSame(35, $results[1]->getEnd());
        $this->assertSame(ProbeType::SE_PERSONNUMMER_MEDICAL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new SePersonnummerMedicalProbe();

        $text = 'Invalid
640823-1237
Tail';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
