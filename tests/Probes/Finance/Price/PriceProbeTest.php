<?php

namespace Tests\Probes\Finance\Price;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Price\PriceProbe;

/**
 * @internal
 */
class PriceProbeTest extends TestCase
{
    public function testFindsAmountWithCurrencyCode(): void
    {
        $probe = new PriceProbe();

        $text = 'Total is 100 USD today.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('100 USD', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsAmountWithCurrencySymbolSuffix(): void
    {
        $probe = new PriceProbe();

        $text = 'Price: 1 500₽ per item';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('1 500₽', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsAmountWithCurrencySymbolPrefix(): void
    {
        $probe = new PriceProbe();

        $text = '$99.99 special offer';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('$99.99', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(6, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsSlashSeparatedCurrencies(): void
    {
        $probe = new PriceProbe();

        $text = 'Dual pricing 99 EUR/UAH and more';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('99 EUR/UAH', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testIgnoresUnknownCurrencyCodes(): void
    {
        $probe = new PriceProbe();

        $text = 'Amount: 200 ABC is not valid';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsAmountWithCommaSeparator(): void
    {
        $probe = new PriceProbe();

        $text = 'Amount: 2,500 USD due';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('2,500 USD', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsAmountWithDecimalComma(): void
    {
        $probe = new PriceProbe();

        $text = 'Total: 19,99 EUR';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('19,99 EUR', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsAmountWithPrefixedSymbolAndCode(): void
    {
        $probe = new PriceProbe();

        $text = 'Price: $100 USD today';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('$100 USD', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsAmountAtStart(): void
    {
        $probe = new PriceProbe();

        $text = '€5.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('€5', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(2, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());
    }

    public function testFindsMultiplePrices(): void
    {
        $probe = new PriceProbe();

        $text = 'Pay 10 USD or €9.99.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertEquals('10 USD', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(10, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[0]->getProbeType());

        $this->assertEquals('€9.99', $results[1]->getResult());
        $this->assertEquals(14, $results[1]->getStart());
        $this->assertEquals(19, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PRICE, $results[1]->getProbeType());
    }
}
