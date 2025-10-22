<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankJcbCardProbe;

class BankJcbCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'My JCB card: 3566002020360505';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3566002020360505', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_JBC_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'JCB: 3566 0020 2036 0505';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3566 0020 2036 0505', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(24, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_JBC_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'Card: 3566-0020-2036-0505';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3566-0020-2036-0505', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_JBC_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'Invalid JCB: 3566002020360506';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'JCB cards: 3566002020360505 and 3528000700000000';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('3566002020360505', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_JBC_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('3528000700000000', $results[1]->getResult());
        $this->assertEquals(32, $results[1]->getStart());
        $this->assertEquals(48, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_JBC_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'Mixed cards: 4111111111111111 and 3566002020360505 and 5500000000000004';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('3566002020360505', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_JBC_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankJcbCardProbe();

        $text = 'Short: 35660020203605';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
