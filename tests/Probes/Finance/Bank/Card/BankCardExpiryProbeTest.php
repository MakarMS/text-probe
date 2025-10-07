<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankCardExpiryProbe;

class BankCardExpiryProbeTest extends TestCase
{
    public function testFindsExpiryWithSlash(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Expiry: 05/24";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('05/24', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_EXPIRY_DATE, $results[0]->getProbeType());
    }

    public function testFindsExpiryWithDash(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Expiry: 05-2025";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('05-2025', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_EXPIRY_DATE, $results[0]->getProbeType());
    }

    public function testFindsExpiryWithDot(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Expiry: 5.25";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('5.25', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_EXPIRY_DATE, $results[0]->getProbeType());
    }

    public function testFindsExpiryWithSpace(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Expiry: 05 25";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('05 25', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_EXPIRY_DATE, $results[0]->getProbeType());
    }

    public function testFindsExpiryWith4DigitYear(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Expiry: 12/2026";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('12/2026', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_EXPIRY_DATE, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidMonth(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Expiry: 13/25";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleExpiryDates(): void
    {
        $probe = new BankCardExpiryProbe();

        $text = "Cards: 05/24 and 11/2025";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('05/24', $results[0]->getResult());
        $this->assertEquals('11/2025', $results[1]->getResult());
    }

    public function testEmptyStringIsInvalid(): void
    {
        $probe = new BankCardExpiryProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testStringWithOnlySpacesIsInvalid(): void
    {
        $probe = new BankCardExpiryProbe();

        $results = $probe->probe('     ');

        $this->assertCount(0, $results);
    }
}
