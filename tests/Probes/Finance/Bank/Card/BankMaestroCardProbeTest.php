<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankMaestroCardProbe;

class BankMaestroCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "My Maestro card: 6759649826438453";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6759649826438453', $results[0]->getResult());
        $this->assertEquals(17, $results[0]->getStart());
        $this->assertEquals(33, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MAESTRO_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "Maestro: 6759 6498 2643 8453";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6759 6498 2643 8453', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MAESTRO_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "Card: 6759-6498-2643-8453";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6759-6498-2643-8453', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MAESTRO_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "Invalid Maestro: 6759649826438452";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "Maestro cards: 6759649826438453 and 5018250000000000";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertEquals('6759649826438453', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MAESTRO_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('5018250000000000', $results[1]->getResult());
        $this->assertEquals(36, $results[1]->getStart());
        $this->assertEquals(52, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_MAESTRO_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "Mixed cards: 4111111111111111 and 6759649826438453 and 5500000000000004";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6759649826438453', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MAESTRO_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankMaestroCardProbe();

        $text = "Short: 67596498264";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
