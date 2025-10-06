<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankTroyCardProbe;

class BankTroyCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "My Troy card: 9792096705533967";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('9792096705533967', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_TROY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "Troy: 9792 4835 7697 0686";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('9792 4835 7697 0686', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_TROY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "Card: 9792-5628-6297-5812";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('9792-5628-6297-5812', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_TROY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "Invalid Troy: 9792096705533960";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "Troy cards: 9792349944986854 and 9792096153868071";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('9792349944986854', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_TROY_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('9792096153868071', $results[1]->getResult());
        $this->assertEquals(33, $results[1]->getStart());
        $this->assertEquals(49, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_TROY_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "Mixed cards: 4111111111111111 and 9792096153868071 and 5555555555554444";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('9792096153868071', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_TROY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankTroyCardProbe();

        $text = "Short: 97920967055";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
