<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\DeUstIdNrProbe;

/**
 * @internal
 */
class DeUstIdNrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE685385472';
        $text = 'Value: DE685385472';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE650331376';
        $text = 'Value: DE650331376';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DeUstIdNrProbe();

        $expectedFirst = 'DE685385472';
        $expectedSecond = 'DE650331376';
        $text = 'First DE685385472 then DE650331376';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE685385472';
        $text = 'DE685385472 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE685385472';
        $text = 'head DE685385472';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE685385472';
        $text = 'Check DE685385472, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new DeUstIdNrProbe();

        $expectedFirst = 'DE685385472';
        $expectedSecond = 'DE685385472';
        $text = 'DE685385472 and DE685385472';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE650331376';
        $text = 'Prefix DE650331376 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new DeUstIdNrProbe();

        $expectedFirst = 'DE685385472';
        $expectedSecond = 'DE650331376';
        $text = 'DE685385472, DE650331376';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new DeUstIdNrProbe();

        $expected = 'DE685385472';
        $text = 'Value: DE685385472';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DE_UST_ID_NR, $results[0]->getProbeType());
    }
}
