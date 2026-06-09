<?php

namespace Tests\Probes\Identity\DriverLicense;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\DriverLicense\UkDrivingLicenceNumberProbe;

/**
 * @internal
 */
class UkDrivingLicenceNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'ABCD9123456FG7HI';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'QWERT1234569Z8YX';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expectedFirst = 'ABCD9123456FG7HI';
        $expectedSecond = 'QWERT1234569Z8YX';
        $text = 'First
' . $expectedFirst . '
then
' . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'ABCD9123456FG7HI';
        $text = $expected . '
Tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'ABCD9123456FG7HI';
        $prefix = 'Head
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'ABCD9123456FG7HI';
        $text = 'Check
' . $expected . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'ABCD9123456FG7HI';
        $text = $expected . '
AND
' . $expected;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = 0;
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expected = 'QWERT1234569Z8YX';
        $text = 'Prefix
' . $expected . '
Suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $expectedFirst = 'ABCD9123456FG7HI';
        $expectedSecond = 'QWERT1234569Z8YX';
        $text = 'First:
' . $expectedFirst . '
And:
' . $expectedSecond . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(45, $results[1]->getEnd());
        $this->assertSame(ProbeType::UK_DRIVING_LICENCE_NUMBER, $results[1]->getProbeType());
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new UkDrivingLicenceNumberProbe();

        $text = 'Invalid
ABCD9123456FG7H
Tail';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
