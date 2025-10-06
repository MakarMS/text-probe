<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankMastercardCardProbe;

class BankMastercardCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "My MasterCard: 5555555555554444";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('5555555555554444', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MASTERCARD_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "MasterCard: 5555 5555 5555 4444";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('5555 5555 5555 4444', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MASTERCARD_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "Card: 5555-5555-5555-4444";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('5555-5555-5555-4444', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MASTERCARD_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "Invalid MasterCard: 5555555555554445";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "MasterCards: 5555555555554444 and 2221000000000009";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertEquals('5555555555554444', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MASTERCARD_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('2221000000000009', $results[1]->getResult());
        $this->assertEquals(34, $results[1]->getStart());
        $this->assertEquals(50, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_MASTERCARD_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "Mixed cards: 4111111111111111 and 5555555555554444 and 378282246310005";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('5555555555554444', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MASTERCARD_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankMastercardCardProbe();

        $text = "Short: 55555555555544";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
