<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\SeVatNummerProbe;

/**
 * @internal
 */
class SeVatNummerProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE916149705301';
        $text = 'Value: SE916149705301';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE649986690001';
        $text = 'Value: SE649986690001';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SeVatNummerProbe();

        $expectedFirst = 'SE916149705301';
        $expectedSecond = 'SE649986690001';
        $text = 'First SE916149705301 then SE649986690001';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE916149705301';
        $text = 'SE916149705301 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE916149705301';
        $text = 'head SE916149705301';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE916149705301';
        $text = 'Check SE916149705301, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SeVatNummerProbe();

        $expectedFirst = 'SE916149705301';
        $expectedSecond = 'SE916149705301';
        $text = 'SE916149705301 and SE916149705301';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(33, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE649986690001';
        $text = 'Prefix SE649986690001 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SeVatNummerProbe();

        $expectedFirst = 'SE916149705301';
        $expectedSecond = 'SE649986690001';
        $text = 'SE916149705301, SE649986690001';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SeVatNummerProbe();

        $expected = 'SE916149705301';
        $text = 'Value: SE916149705301';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SE_NUMMER, $results[0]->getProbeType());
    }
}
