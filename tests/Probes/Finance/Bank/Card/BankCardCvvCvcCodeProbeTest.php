<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankCardCvvCvcCodeProbe;

class BankCardCvvCvcCodeProbeTest extends TestCase
{
    public function testFinds3DigitCvv(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $text = "My CVV is 123";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('123', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_CVV_CVC_CODE, $results[0]->getProbeType());
    }

    public function testFinds4DigitCvv(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $text = "Amex CVV: 1234";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1234', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(14, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_CVV_CVC_CODE, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidLength(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $text = "Too short: 12";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);

        $text = "Too long: 12345";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCvvs(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $text = "CVVs: 123 and 9876";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('123', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(9, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_CVV_CVC_CODE, $results[0]->getProbeType());

        $this->assertEquals('9876', $results[1]->getResult());
        $this->assertEquals(14, $results[1]->getStart());
        $this->assertEquals(18, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_CVV_CVC_CODE, $results[1]->getProbeType());
    }

    public function testIgnoresNonDigits(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $text = "Invalid: abc";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testEmptyStringIsInvalid(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testStringWithSpacesOnlyIsInvalid(): void
    {
        $probe = new BankCardCvvCvcCodeProbe();

        $results = $probe->probe('     ');

        $this->assertCount(0, $results);
    }
}
