<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankAmexCardProbe;

class BankAmexCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "My Amex card: 378282246310005";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('378282246310005', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_AMEX_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "Amex: 3782 822463 10005";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3782 822463 10005', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_AMEX_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "Card: 3782-822463-10005";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3782-822463-10005', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_AMEX_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "Invalid Amex: 3412345678901";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "Amex cards: 340000000000009 and 371449635398431";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('340000000000009', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_AMEX_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('371449635398431', $results[1]->getResult());
        $this->assertEquals(32, $results[1]->getStart());
        $this->assertEquals(47, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_AMEX_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "Mixed cards: 4111111111111111 and 378282246310005 and 5500000000000004";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('378282246310005', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_AMEX_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankAmexCardProbe();

        $text = "Short: 37828224631";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
