<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankDiscoverCardProbe;

class BankDiscoverCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "My Discover card: 6011000990139424";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6011000990139424', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(34, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DISCOVER_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "Discover: 6011 0009 9013 9424";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6011 0009 9013 9424', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DISCOVER_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "Card: 6011-0009-9013-9424";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6011-0009-9013-9424', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DISCOVER_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "Invalid Discover: 6011000990139423";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "Discover cards: 6011000990139424 and 6221260000000000";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertEquals('6011000990139424', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(32, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DISCOVER_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('6221260000000000', $results[1]->getResult());
        $this->assertEquals(37, $results[1]->getStart());
        $this->assertEquals(53, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_DISCOVER_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "Mixed cards: 4111111111111111 and 6011000990139424 and 5500000000000004";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('6011000990139424', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DISCOVER_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankDiscoverCardProbe();

        $text = "Short: 6011000990139";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
