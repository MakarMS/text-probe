<?php

namespace Tests\Probes\Identity\TaxNumber;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\TaxNumber\ItCodiceFiscaleProbe;

/**
 * @internal
 */
class ItCodiceFiscaleProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'RSSMRA85T10A562S';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'VRDLGI90A01H501G';
        $prefix = 'Value:
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expectedFirst = 'RSSMRA85T10A562S';
        $expectedSecond = 'BNCLGU87M05H501L';
        $text = 'First
' . $expectedFirst . '
then
' . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'RSSMRA85T10A562S';
        $text = $expected . '
Tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'RSSMRA85T10A562S';
        $prefix = 'Head
';
        $text = $prefix . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'RSSMRA85T10A562S';
        $text = 'Check
' . $expected . '
End.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'RSSMRA85T10A562S';
        $text = $expected . '
AND
' . $expected;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = 0;
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expected = 'BNCLGU87M05H501L';
        $text = 'Prefix
' . $expected . '
Suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $expectedFirst = 'RSSMRA85T10A562S';
        $expectedSecond = 'BNCLGU87M05H501L';
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
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(45, $results[1]->getEnd());
        $this->assertSame(ProbeType::IT_CODICE_FISCALE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidChecksum(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $text = 'Invalid
RSSMRA85T10A562A
Tail';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new ItCodiceFiscaleProbe();

        $text = 'Invalid
INVALID
Tail';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
