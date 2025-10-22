<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankUnionpayCardProbe;

class BankUnionpayCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'My UnionPay card: 6249166746947115';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6249166746947115', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(34, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_UNIONPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'UnionPay: 6288 2340 3193 2390';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6288 2340 3193 2390', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_UNIONPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'Card: 6264-9399-6927-53984';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6264-9399-6927-53984', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_UNIONPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'Invalid UnionPay: 6249166746947114';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'UnionPay cards: 629831196200679717 and 6205590089026178861';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('629831196200679717', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(34, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_UNIONPAY_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('6205590089026178861', $results[1]->getResult());
        $this->assertEquals(39, $results[1]->getStart());
        $this->assertEquals(58, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_UNIONPAY_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'Mixed cards: 4111111111111111 and 629831196200679717 and 5555555555554444';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('629831196200679717', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(52, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_UNIONPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankUnionpayCardProbe();

        $text = 'Short: 6249166746947';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
