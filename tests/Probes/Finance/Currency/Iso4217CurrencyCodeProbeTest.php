<?php

namespace Tests\Probes\Finance\Currency;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Currency\Iso4217CurrencyCodeProbe;

/**
 * @internal
 */
class Iso4217CurrencyCodeProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'USD';
        $text = 'Value: USD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'EUR';
        $text = 'Value: EUR';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expectedFirst = 'USD';
        $expectedSecond = 'EUR';
        $text = 'First USD then EUR';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(18, $results[1]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'USD';
        $text = 'USD tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'USD';
        $text = 'head USD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(8, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'USD';
        $text = 'Check USD, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expectedFirst = 'USD';
        $expectedSecond = 'USD';
        $text = 'USD and USD';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(8, $results[1]->getStart());
        $this->assertSame(11, $results[1]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'EUR';
        $text = 'Prefix EUR suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expectedFirst = 'USD';
        $expectedSecond = 'EUR';
        $text = 'USD, EUR';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(5, $results[1]->getStart());
        $this->assertSame(8, $results[1]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new Iso4217CurrencyCodeProbe();

        $expected = 'USD';
        $text = 'Value: USD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISO4217_CURRENCY_CODE, $results[0]->getProbeType());
    }
}
