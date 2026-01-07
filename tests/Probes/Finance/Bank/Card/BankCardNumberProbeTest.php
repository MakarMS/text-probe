<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankCardNumberProbe;

/**
 * @internal
 */
class BankCardNumberProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'My card: 4111111111111111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111111111111111', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Card number: 4111 1111 1111 1111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111 1111 1111 1111', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(32, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Number: 4111-1111-1111-1111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111-1111-1111-1111', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Invalid card: 1234567890123';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Cards: 4111111111111111 and 5500000000000004';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('4111111111111111', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('5500000000000004', $results[1]->getResult());
        $this->assertEquals(28, $results[1]->getStart());
        $this->assertEquals(44, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testFindsAmexCardNumber(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Amex 378282246310005 ok';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('378282246310005', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsDiscoverCardNumber(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Discover 6011000990139424';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6011000990139424', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberAtStart(): void
    {
        $probe = new BankCardNumberProbe();

        $text = '4111111111111111 end';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111111111111111', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsUnionPayCardNumber(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Union 6205590089026178861 card';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6205590089026178861', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankCardNumberProbe();

        $text = 'Short number: 4111111';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
