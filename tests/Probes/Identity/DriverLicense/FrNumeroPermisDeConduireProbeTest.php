<?php

namespace Tests\Probes\Identity\DriverLicense;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\DriverLicense\FrNumeroPermisDeConduireProbe;

/**
 * @internal
 */
class FrNumeroPermisDeConduireProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '123456789012';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '999999999999';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expectedFirst = '123456789012';
        $expectedSecond = '999999999999';
        $text = 'First
' . $expectedFirst . '
then
' . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(24, $results[1]->getStart());
        $this->assertSame(36, $results[1]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '123456789012';
        $text = $expected . '
Tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '123456789012';
        $prefix = 'Head
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '123456789012';
        $text = 'Check
' . $expected . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '123456789012';
        $text = $expected . '
AND
' . $expected;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = 0;
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(17, $results[1]->getStart());
        $this->assertSame(29, $results[1]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expected = '999999999999';
        $text = 'Prefix
' . $expected . '
Suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $expectedFirst = '123456789012';
        $expectedSecond = '999999999999';
        $text = 'First:
' . $expectedFirst . '
And:
' . $expectedSecond . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new FrNumeroPermisDeConduireProbe();

        $text = 'Invalid
12345678901
Tail';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
